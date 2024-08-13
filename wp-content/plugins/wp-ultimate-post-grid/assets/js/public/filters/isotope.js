window.WPUPG_Filter_isotope = {
    init: ( gridElemId, args ) => {
        const id = `${ gridElemId }-filter-${ args.id }`;
        const elem = document.querySelector( '#' + id );

        if ( ! elem ) {
            return false;
        }

        let filter = {
            gridElemId,
            args,
            id,
            elem,
            selected: {},
            getSelectors() {
                let selectors = false;

                if ( 0 < Object.keys( this.selected ).length ) {
                    let termSelectors = [];

                    if ( 'custom_field' === this.args.source ) {
                        termSelectors = WPUPG_Grids[ this.gridElemId ].getCustomFieldSelectors( this.selected, this.args );
                    } else {
                        for ( let taxonomy of Object.keys( this.selected ) ) {
                            for ( let term of this.selected[ taxonomy ] ) {
                                termSelectors.push( this.args.match_parents ? `.wpupg-parent-tax-${ taxonomy }-${ term }` : `.wpupg-tax-${ taxonomy }-${ term }` );
                            }
                        }
                    }

                    if ( 'match_all' === this.args.multiselect_type ) {
                        selectors = [ termSelectors.join( '' ) ];
                    } else {
                        selectors = termSelectors;
                    }

                    // Take care of optional inverse.
                    if ( this.args.inverse ) {
                        selectors = [ `:not(${ selectors.join( ', ' ) })` ];
                    }
                }

                return selectors;
            },
            getQueryArgs() {
                if ( '{}' === JSON.stringify( this.selected ) ) {
                    return false;
                } else {
                    if ( 'custom_field' === this.args.source ) {
                        return WPUPG_Grids[ this.gridElemId ].getCustomFieldQueryArgs( this.selected, this.args );
                    } else {
                        return {
                            'type': 'terms',
                            'terms': this.selected,
                            'terms_inverse': this.args.inverse,
                            'terms_relation': 'match_all' === this.args.multiselect_type ? 'AND' : 'OR',
                        };
                    }
                }
            },
            getDeeplink() {
                let deeplink = [];
                
                for ( let taxonomy of Object.keys( this.selected ) ) {
                    if ( 0 < this.selected[ taxonomy ].length ) {
                        deeplink.push( `${ taxonomy }:${ this.selected[ taxonomy ].join( ',' ) }` );
                    }
                }

                return deeplink.join( '+' );
            },
            restoreDeeplink( key, value ) {
                if ( value ) {
                    const terms = value.split( ',' );

                    for ( let term of terms ) {
                        let button = false;

                        if ( 'custom_field' === this.args.source ) {
                            button = this.elem.querySelector( `.wpupg-filter-isotope-custom-field[data-value="${ term }"]` );
                        } else {
                            button = this.elem.querySelector( `.wpupg-filter-isotope-term-${ key }.wpupg-filter-tag-${ term }` );
                        }

                        if ( button ) {
                            this.onClickButton( button, true );
                        }
                    }
                }
            },
            clear() {
                // Set all buttons as inactive.
                for ( let button of this.buttons ) {
                    button.classList.remove( 'active' );
                }

                // Activate All button if it's there.
                if ( this.buttonAll ) {
                    this.buttonAll.classList.add( 'active' );
                }

                // Set selections.
                this.selected = {};
            },
            buttonAll: false,
            onClickButton( button, forceActive = false, callback = false ) {
                let clickedAllButton = button === this.buttonAll;
                const wasActive = ! forceActive && button.classList.contains( 'active' );
    
                // Deactivate All Button.
                if ( this.buttonAll ) {
                    this.buttonAll.classList.remove( 'active' );
                }
    
                // Deactivate other buttons (unless multiselect).
                if ( clickedAllButton || ! this.args.multiselect ) {
                    for ( let otherButton of this.buttons ) {
                        otherButton.classList.remove( 'active' );
                    }
                }
                
                // Toggle current button active state.
                if ( clickedAllButton || ! wasActive ) {
                    button.classList.add( 'active' );
                } else {
                    button.classList.remove( 'active' );
    
                    // Check if there are any active buttons remaining, otherwise activate all.
                    if ( 0 === this.elem.querySelectorAll( '.wpupg-filter-isotope-term.active' ).length ) {
                        if ( this.buttonAll ) {
                            this.buttonAll.classList.add( 'active' );
                        }
                        clickedAllButton = true;
                    }
                }

                // Set focus on first active button or hover cover remains.
                if ( wasActive ) {
                    const activeButtons = this.elem.querySelectorAll( '.wpupg-filter-isotope-term.active' );
                    if ( 0 < activeButtons.length ) {
                        activeButtons[0].focus();
                    }
                }
    
                // Update selectors.
                if ( clickedAllButton ) {
                    this.selected = {};
                } else {
                    if ( ! this.args.multiselect ) {
                        this.selected = {};
                    }

                    let taxonomy;
                    let terms;

                    if ( 'custom_field' === this.args.source ) {
                        taxonomy = this.args.custom_field;
                        terms = [ button.dataset.value ];
                    } else {
                        taxonomy = button.dataset.taxonomy;
                        terms = button.dataset.terms.split(';');
                    }

                    if ( ! this.selected.hasOwnProperty( taxonomy ) ) {
                        this.selected[ taxonomy ] = [];
                    }
    
                    for ( let term of terms ) {
                        // Add/remove selector for this button.
                        if ( wasActive ) {
                            this.selected[ taxonomy ] = this.selected[ taxonomy ].filter( t => t !== term );
                        } else {
                            if ( ! this.selected[ taxonomy ].includes( term ) ) {
                                this.selected[ taxonomy ].push( term );
                            }
                        }
                    }

                    // Clean up if empty.
                    if ( 0 === this.selected[ taxonomy ].length ) {
                        delete this.selected[ taxonomy ];
                    }
                }
    
                // Trigger grid filter.
                if ( clickedAllButton ) {
                    WPUPG_Grids[ this.gridElemId ].filter();
                } else {
                    WPUPG_Grids[ this.gridElemId ].maybeLoadItemsAndFilter();
                }

                if ( false !== callback ) {
                    callback();
                }
            },
            init() {
                // Prefilter isotope.
                if ( args.hasOwnProperty( 'prefilter' ) ) {
                    WPUPG_Grids[ this.gridElemId ].on( 'restoredDeeplink', () => {
                        for ( let taxonomy of Object.keys( args.prefilter ) ) {
                            const terms = args.prefilter[ taxonomy ];
    
                            for ( let term of terms ) {
                                const button = this.elem.querySelector( `.wpupg-filter-isotope-term-${ taxonomy }.wpupg-filter-tag-${ term }` );
        
                                if ( button ) {
                                    this.onClickButton( button, true );
                                }
                            }
                        }
                    });
                }
            },
        }

        filter.buttons = elem.querySelectorAll( '.wpupg-filter-isotope-term' );

        for ( let button of filter.buttons ) {
            if ( button.classList.contains( 'wpupg-filter-isotope-all' ) ) {
                filter.buttonAll = button;
            }

            button.addEventListener( 'click', (e) => {
                if ( e.which === 1 ) { // Left mouse click.
                    filter.onClickButton( button );
                    button.blur();
                }
            } );
            button.addEventListener( 'keydown', (e) => {
                if ( e.which === 13 || e.which === 32 ) { // Space or ENTER.
                    filter.onClickButton( button );
                }
            } );
        }

        return filter;
    },
}