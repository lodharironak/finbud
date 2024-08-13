export default ( elemId, args ) => {
    return {
        currentDevice: false,
        checkDevice() {
            const device = this.getDevice();

            if ( device !== this.currentDevice ) {
                this.updateDevice( device );

                // Only need to reinit toggles if device changes.
                this.initToggles();
            }
        },
        updateDevice( device ) {
            this.currentDevice = device;

            // Update grid.
            let elemsToUpdate = [ this.elem ];

            // And filters.
            for ( let filter of this.filters ) {
                if ( filter.hasOwnProperty( 'elem' ) && filter.elem ) {
                    // Check for parent first.
                    const filterParent = filter.elem.parentElement;

                    if ( filterParent.classList.contains( 'wpupg-filter-container' ) ) {
                        elemsToUpdate.push( filterParent );
                    } else {
                        elemsToUpdate.push( filter.elem );
                    }
                }
            }

            for ( let elem of elemsToUpdate ) {
                // Remove existing classes.
                elem.classList.remove( 'wpupg-responsive-desktop' );
                elem.classList.remove( 'wpupg-responsive-tablet' );
                elem.classList.remove( 'wpupg-responsive-mobile' );

                // Add new device class.
                elem.classList.add( `wpupg-responsive-${device}` );
            }
        },
        getDevice() {
            let device = 'desktop';

            if ( this.isPreview ) {
                // Check what preview mode is enabled.
                const activePreview = document.querySelector( '.wpupg-admin-modal-grid-preview-device.active' );

                if ( activePreview ) {
                    device = activePreview.dataset.device;
                }
            } else {
                // Use viewport on actual site.
                const viewport = this.getViewport();

                if ( viewport.width <= wpupg_public.breakpoints.tablet ) {
                    device = 'tablet';
                }
                if ( viewport.width <= wpupg_public.breakpoints.mobile ) {
                    device = 'mobile';
                }
            }

            return device;
        },
        getViewport() {
            // Source: https://stackoverflow.com/questions/19291873/window-width-not-the-same-as-media-query/19292035#19292035
            var e = window, a = 'inner';
            if (!('innerWidth' in window )) {
                a = 'client';
                e = document.documentElement || document.body;
            }
            return { width : e[ a+'Width' ] , height : e[ a+'Height' ] };
        },
        initToggles() {
            if ( this.currentDevice ) {
                // Loop all filters.
                for ( let filter of this.filters ) {
                    if ( filter.hasOwnProperty( 'elem' ) && filter.elem ) {
                        const filterContainer = filter.elem.parentElement;
                        const filterLabel = filterContainer.querySelector( '.wpupg-filter-label' );

                        // Remove any existing toggle result.
                        filter.elem.style.display = '';
                        if ( filterContainer.querySelector( '.wpupg-filter-toggle-closed' ) ) {
                            filterContainer.querySelector( '.wpupg-filter-toggle-closed' ).style.display = '';
                        }
                        if ( filterContainer.querySelector( '.wpupg-filter-toggle-open' ) ) {
                            filterContainer.querySelector( '.wpupg-filter-toggle-open' ).style.display = '';
                        }

                        if ( filterLabel ) {
                            // Remove existing event.
                            filterLabel.removeEventListener( 'click', this.clickedToggle, false );
                            filterLabel.removeEventListener( 'keydown', this.clickedToggle, false );

                            // Add click event if filter is toggleable on current device.
                            if ( filterContainer.classList.contains( `wpupg-filter-container-${ this.currentDevice }-toggle` ) ) {
                                filterLabel.addEventListener( 'click', this.clickedToggle );
                                filterLabel.addEventListener( 'keydown', this.clickedToggle );

                                filterContainer.dataset.toggle = filterContainer.classList.contains( `wpupg-filter-container-${ this.currentDevice }-toggle_open` ) ? 'open' : 'closed';
                            }
                        }
                    }
                }
            }
        },
        clickedToggle( e ) {

            // Allow click or keypress (accessibility).
            const key = e.which || e.keyCode || 0;

            if ( 'click' === e.type || ( 13 === key || 32 === key ) ) {
                e.preventDefault();

                // Get container.
                let filterContainer = false;

                for ( var target = e.target; target; target = target.parentNode ) {
                    if ( target.matches( '.wpupg-filter-container' ) ) {
                        filterContainer = target;
                        break;
                    }
                }

                if ( filterContainer ) {
                    const currentState = filterContainer.dataset.toggle;

                    if ( 'closed' === currentState ) {
                        // Toggle icons.
                        filterContainer.querySelector( '.wpupg-filter-toggle-closed' ).style.display = 'none';
                        filterContainer.querySelector( '.wpupg-filter-toggle-open' ).style.display = 'inline';

                        filterContainer.querySelector( '.wpupg-filter' ).style.display = 'block';
                        
                        filterContainer.dataset.toggle = 'open';
                    } else {
                        filterContainer.querySelector( '.wpupg-filter-toggle-open' ).style.display = 'none';
                        filterContainer.querySelector( '.wpupg-filter-toggle-closed' ).style.display = 'inline';

                        filterContainer.querySelector( '.wpupg-filter' ).style.display = 'none';

                        filterContainer.dataset.toggle = 'closed';
                    }
                }
            }
        },
        initResponsive() {
            this.checkDevice();

            this.isotope.on( 'layoutComplete', () => {
                this.checkDevice();
            } );

            // When previewing, update device immediately after clicking on a preview link.
            if ( this.isPreview ) {
                const previewDevices = document.querySelectorAll( '.wpupg-admin-modal-grid-preview-device' );

                for ( let previewDevice of previewDevices ) {
                    previewDevice.addEventListener( 'click', (e) => {
                        this.updateDevice( e.target.dataset.device );
                    } );
                }
            }
        }
    }
};