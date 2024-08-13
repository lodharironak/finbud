import animateScrollTo from 'animated-scroll-to';

window.WPUPG_Pagination_pages = {
    init: ( gridElemId, args ) => {
        const id = `${ gridElemId }-pagination`;
        const elem = document.querySelector( '#' + id );

        let pagination = {
            gridElemId,
            args,
            id,
            elem,
            page: 0,
            pagesLoaded: [0],
            totalPages: false,
            getDeeplink() {
                return this.page ? `p:${ this.page }` : '';
            },
            restoreDeeplink( key, value ) {
                if ( 'p' === key ) {
                    const button = this.elem.querySelector( `.wpupg-pagination-term.wpupg-page-${ value }` );

                    if ( button ) {
                        return new Promise((resolve) => {
                            this.onClickButton( button, () => {
                                resolve();
                            } );
                        });
                    }
                }
            },
            getSelector() {
                if ( this.adaptingPages ) {
                    return '';
                } else {
                    return `.wpupg-page-${ this.page }`;   
                }
            },
            onClickButton( button, callback = false ) {
                const wasActive = button.classList.contains( 'active' );

                if ( ! wasActive ) {
                    // Deactivate other buttons.
                    for ( let otherButton of this.buttons ) {
                        otherButton.classList.remove( 'active' );
                    }

                    // Set current button active.
                    button.classList.add( 'active' );

                    // Scroll to top of grid if not in view.
                    const gridElem = WPUPG_Grids[ this.gridElemId ].elem;
                    const bounding = gridElem.getBoundingClientRect();

                    if ( bounding.top < 0 ) {
                        animateScrollTo( gridElem, {
                            verticalOffset: -100,
                            speed: 500,
                        } );
                    }

                    // Load page.
                    this.changePage( button, ( page ) => {
                        this.page = page;

                        // Trigger grid filter.
                        WPUPG_Grids[ pagination.gridElemId ].filter();

                        // Optional callback.
                        if ( false !== callback ) {
                            callback( page );
                        }
                    });
                }
            },
            changePage( button, callback = false ) {
                const page = parseInt( button.dataset.page );

                if ( this.pagesLoaded.includes( page ) || ( this.args.adaptive_pages && '.wpupg-item' !== this.currentFilterString ) ) {
                    callback( page );
                    this.contractPages();
                } else {
                    // Set Loading state for button.
                    const buttonStyle = window.getComputedStyle( button );
                    const backgroundColor = buttonStyle.getPropertyValue( 'background-color' );

                    button.style.color = backgroundColor;
                    button.classList.add( 'wpupg-spinner' );

                    // Load next page.
                    WPUPG_Grids[ pagination.gridElemId ].loadItems({
                        page,
                    }, () => {
                        button.classList.remove( 'wpupg-spinner' );
                        button.style.color = '';

                        this.pagesLoaded.push( page );

                        if ( '.wpupg-item' === this.currentFilterString ) {
                            this.adaptPageClasses(); // Need to update page classes if new items have been loaded. Do before callback, where the grid gets filtered.
                        }

                        if ( false !== callback ) {
                            callback( page );
                        }
                        this.contractPages();
                    })
                }
            },
            adaptingPages: false,
            currentFilterString: '.wpupg-item',
            adaptPages() {
                if ( this.args.adaptive_pages ) {
                    const grid = WPUPG_Grids[ pagination.gridElemId ];

                    // Get current filter string without page selector. If empty, it matches everything.
                    this.adaptingPages = true;
                    let filterString = grid.getFilterString();
                    this.adaptingPages = false;

                    if ( '' === filterString ) {
                        filterString = '.wpupg-item';
                    }
                    filterString = filterString.replace( ':', '.wpupg-item:' );
                    
                    if ( filterString !== this.currentFilterString ) {
                        this.currentFilterString = filterString;

                        // Set correct page classes and get total number of pages.
                        let totalPages = this.adaptPageClasses();

                        // Show/hide page buttons as needed.                        
                        let pageButton = 0;
                        for ( let button of this.buttons ) {
                            button.classList.remove( 'active' );
                            button.classList.remove( 'unused' );

                            if ( pageButton < totalPages ) {
                                button.style.display = '';

                                if ( 0 === pageButton ) {
                                    button.classList.add( 'active' );
                                }
                            } else {
                                button.classList.add( 'unused' );
                                button.style.display = 'none';
                            }
                            pageButton++;
                        }

                        // Starting at page 0.
                        this.page = 0;

                        // New set of buttons, contract if needed.
                        this.contractPages();
                    }
                }
            },
            adaptPageClasses() {
                let totalPages = this.totalPages;

                if ( this.args.adaptive_pages ) {
                    const grid = WPUPG_Grids[ pagination.gridElemId ];

                    // Remove any wpupg-page-x class.
                    const items = grid.elem.querySelectorAll( '.wpupg-item' );
                    for ( let item of items ) {
                        item.className = item.className.replace( /wpupg\-page\-\d+/gm, '' );
                    }

                    let filteredItems = grid.elem.querySelectorAll( this.currentFilterString );
                    const filteredItemsOrdered = grid.getSortedOrder( filteredItems );

                    let page = 0;
                    let itemsInPage = 0;

                    for ( let index of filteredItemsOrdered ) {
                        filteredItems[ index ].classList.add( `wpupg-page-${page}` );
                        itemsInPage++;

                        if ( itemsInPage >= this.args.posts_per_page ) {
                            page++;
                            itemsInPage = 0;

                            if ( '.wpupg-item' === this.currentFilterString ) {
                                while ( page <= totalPages && ! this.pagesLoaded.includes( page ) ) {
                                    page++;
                                }
                            }
                        }
                    }

                    if ( ! totalPages || '.wpupg-item' !== this.currentFilterString ) {
                        totalPages = 0 < itemsInPage ? page + 1 : page;
                    }
                }

                return totalPages;
            },
            contractPages() {
                // Contract buttons if max number of buttons set.
                const maxButtons = this.args.hasOwnProperty( 'max_buttons' ) ? parseInt( this.args.max_buttons ) : 0;

                if ( 5 <= maxButtons ) {
                    let buttonsUsed = 0;
                    for ( let button of this.buttons ) {
                        if ( ! button.classList.contains( 'unused' ) ) {
                            buttonsUsed++;
                        }
                    }

                    if ( maxButtons < buttonsUsed ) {

                        // Always show first and last page, current page, previous and next.
                        let buttonsToShow = [0, this.page - 1, this.page, this.page + 1, buttonsUsed - 1];

                        // Only keep uniques and inside of range.
                        buttonsToShow = [ ...new Set( buttonsToShow ) ];
                        buttonsToShow = buttonsToShow.filter( (b) => 0 <= b && b < buttonsUsed );


                        let i = 0;
                        do {
                            let leftToAdd = maxButtons - buttonsToShow.length;

                            // If 4 or more left, add to front and back.
                            if ( 4 <= leftToAdd ) {
                                // Add to front.
                                let front = 1;
                                while ( buttonsToShow.includes( front ) ) {
                                    front++;
                                }
                                buttonsToShow.push( front );
                                leftToAdd--;

                                // Add to back.
                                let back = buttonsUsed - 2;
                                while ( buttonsToShow.includes( back ) ) {
                                    back--;
                                }
                                buttonsToShow.push( back );
                                leftToAdd--;
                            }

                            // Add around page.
                            let distanceFromPage = 2;
                            let above = true;
                            while ( 0 < leftToAdd ) {
                                let buttonToAdd = above ? this.page + distanceFromPage : this.page - distanceFromPage;

                                if ( 0 <= buttonToAdd && buttonToAdd < buttonsUsed && ! buttonsToShow.includes( buttonToAdd ) ) {
                                    buttonsToShow.push( buttonToAdd );
                                    leftToAdd--;
                                }

                                if ( above ) {
                                    above = false;
                                } else {
                                    above = true;
                                    distanceFromPage++;
                                }
                            }

                            // Only keep uniques and inside of range.
                            buttonsToShow = [ ...new Set( buttonsToShow ) ];
                            buttonsToShow = buttonsToShow.filter( (b) => 0 <= b && b < buttonsUsed );

                            // Prevent infinite loop.
                            if ( i > 999 ) {
                                console.log( 'WPUPG Infinite loop problem!' );
                                break;
                            }
                            i++;
                        } while ( buttonsToShow.length < maxButtons );

                        // Sort numerically.
                        buttonsToShow = buttonsToShow.sort( (a, b) => a - b );

                        // Hide buttons as needed.
                        let pageButton = 0;
                        let lastButtonShown = 0;
                        for ( let button of this.buttons ) {
                            button.classList.remove( 'wpupg-pagination-button-gap' );

                            if ( buttonsToShow.includes( pageButton ) ) {
                                button.style.display = '';

                                // Need to indicate gap?
                                if ( lastButtonShown < pageButton - 1 ) {
                                    button.classList.add( 'wpupg-pagination-button-gap' );
                                }

                                lastButtonShown = pageButton;
                            } else {
                                button.style.display = 'none';
                            }
                            pageButton++;

                            // Stop if we've reached the end of the number of buttons used.
                            if ( pageButton >= buttonsUsed ) {
                                break;
                            }
                        }
                    }
                }
            },
            init() {
                if ( this.buttons && 0 < this.buttons.length ) {
                    this.contractPages();
                    WPUPG_Grids[ pagination.gridElemId ].on( 'filter', () => {
                        this.adaptPages();
                    });
                }
            },
        }

        if ( elem ) {
            pagination.buttons = elem.querySelectorAll( '.wpupg-pagination-term' );
            pagination.totalPages = pagination.buttons.length;

            // Add event listeners.
            for ( let button of pagination.buttons ) {
                button.addEventListener( 'click', (e) => {
                    if ( e.which === 1 ) { // Left mouse click.
                        pagination.onClickButton( button );
                    }
                } );
                button.addEventListener( 'keydown', (e) => {
                    if ( e.which === 13 || e.which === 32 ) { // Space or ENTER.
                        pagination.onClickButton( button );
                    }
                } );
            }
        }

        return pagination;
    },
}