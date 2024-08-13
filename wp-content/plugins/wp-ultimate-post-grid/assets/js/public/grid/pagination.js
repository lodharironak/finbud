import imagesLoaded from 'imagesloaded';

import Api from '../Api';

export default ( elemId, args ) => {
    let pagination = false;
    const paginationType = args.pagination_type;
    if ( 'none' !== paginationType ) {
        if ( 'object' === typeof window[ 'WPUPG_Pagination_' + paginationType ] ) {
            pagination = window[ 'WPUPG_Pagination_' + paginationType ].init( elemId, args.pagination );
        }
    }

    return {
        pagination,
        dynamicRules: args.hasOwnProperty( 'dynamic_rules' ) ? args.dynamic_rules : [],
        itemIds: args.hasOwnProperty( 'item_ids' ) ? args.item_ids : [],
        totalIds: args.hasOwnProperty( 'total_ids' ) ? args.total_ids : false,
        loadItems( args, callback = false ) {
            // Make sure type is set.
            args.type = args.hasOwnProperty( 'type' ) ? args.type : 'load';

            // Get filter query args.
            if ( ! args.hasOwnProperty( 'filters' ) ) {
                const filterArgs = [];
                for ( let filter of this.filters ) {
                    if ( filter.hasOwnProperty( 'getQueryArgs' ) ) {
                        const queryArgs = filter.getQueryArgs();

                        if ( queryArgs ) {
                            filterArgs.push( queryArgs );
                        }
                    }
                }
                args.filters = filterArgs;
            }

            // Add to load items queue.
            this.loadItemsQueue.push({
                args,
                callback,
            });
            this.loadNextInQueue();
        },
        loadItemsQueue: [],
        loadingItems: false,
        loadNextInQueue() {
            if ( ! this.loadingItems && 0 < this.loadItemsQueue.length ) {
                // Start optional pagination loader.
                if ( this.pagination && this.pagination.hasOwnProperty( 'startLoader' ) ) {
                    this.pagination.startLoader();
                }

                this.loadingItems = true;
                const nextLoad = this.loadItemsQueue.shift();
        
                this.loadItemsQueued( nextLoad.args, nextLoad.callback )
                    .then( ( response ) => {
                        this.loadingItems = false;
                        this.loadNextInQueue();
                    })
                    .catch( ( error ) => {
                        this.loadingItems = false;
                        this.loadNextInQueue();
                    } );
            } else if ( ! this.loadItemsQueue.length ) {
                // Stop optional pagination loader.
                if ( this.pagination && this.pagination.hasOwnProperty( 'stopLoader' ) ) {
                    this.pagination.stopLoader();
                }
            }
        },
        loadItemsQueued( args, callback ) {
            // Exclude items already loaded.
            args.loaded_ids = this.itemIds;

            // Add dynamic rules.
            args.dynamic_rules = this.dynamicRules;

            // Get new items through API.
            const body = {
                id: this.gridId,
                args,
            }

            if ( wpupg_public.debugging ) { console.log( 'WPUPG Load Items - body', body ); }
            return Api.loadItems( body ).then((data) => {
                if ( wpupg_public.debugging ) { console.log( 'WPUPG Load Items - data', data ); }
                if ( data && data.items && data.items.hasOwnProperty( 'ids' ) ) {
                    const newIds = Array.isArray( data.items.ids ) ? data.items.ids : Object.values( data.items.ids );
                    this.itemIds = this.itemIds.concat( newIds );
                    this.insertItems( data.items.html );
                }

                this.fireEvent( 'itemsLoaded', data );

                if ( false !== callback ) {
                    callback( data );
                }
            });
        },
        loadOnFilter: args.pagination.hasOwnProperty( 'load_on_filter' ) ? args.pagination.load_on_filter : false,
        maybeLoadItemsAndFilter( args = {}, callback = false ) {
            // Check if args includes search filter.
            let hasSearchFilter = false;
            if ( args.hasOwnProperty( 'filters' ) ) {
                for ( let filter of args.filters ) {
                    if ( 'search' === filter.type ) {
                        hasSearchFilter = true;
                        break;
                    }
                }
            }

            // If all items have been loaded, no need for an API call. Unless we're doing a text search.
            if ( ! hasSearchFilter && this.totalIds && this.itemIds.length >= this.totalIds ) {
                if ( wpupg_public.debugging ) { console.log( 'WPUPG No API call needed, all items loaded - ', this.totalIds ); }
                this.filter();

                if ( false !== callback ) {
                    callback( false );
                }
            } else {
                // Still items left to be loaded.
                if ( this.loadOnFilter ) {
                    this.loadItems( {
                        ...args,
                        type: 'load_all',
                    }, ( data ) => {
                        this.filter();
    
                        if ( false !== callback ) {
                            callback( data );
                        }
                    } );
                } else {
                    this.filter();
                    this.loadItems( {
                        ...args,
                        type: 'count',
                    }, callback );
                }
            }
        },
        insertItems( html ) {
            const domparser = new DOMParser();
            const parsed = domparser.parseFromString( html, 'text/html' );
            const items = parsed.body.children;

            // Indicate item as being inserted.
            for ( let item of items ) {
                item.classList.add( 'wpupg-item-inserted' );
            }

            // Insert into grid.
            this.isotope.insert( items );

            // Update newly inserted items.
            const inserted = this.elem.querySelectorAll( '.wpupg-item-inserted' );

            for ( let item of inserted ) {
                // Force image take up its space.
                const images = item.querySelectorAll( 'img' );
                
                for ( let image of images ) {
                    image.outerHTML = image.outerHTML;
                }

                item.classList.remove( 'wpupg-item-inserted' );
            }

            // Relayout grid when the images above have actually loaded.
            imagesLoaded( this.elem, () => {
                this.layout();
            } );
        },
        initPagination() {
            if ( pagination.hasOwnProperty( 'init' ) ) {
                pagination.init();
            }
        }
    }
};