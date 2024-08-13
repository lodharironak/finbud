export default ( elemId, args ) => {
    return {
        prevVisibleItemCount: 0,
        prevFilterString: '',
        events: {},
        on( event, callback ) {
            if ( ! this.events.hasOwnProperty( event ) ) {
                this.events[ event ] = [];
            }

            this.events[ event ].push( callback );
        },
        fireEvent( event, data = {} ) {
            if ( this.events.hasOwnProperty( event ) ) {
                for ( let callback of this.events[ event ] ) {
                    callback( data );
                }
            }

            // Global init event.
            if ( 'initReady' === event ) {
                window.dispatchEvent( new CustomEvent( 'wpupgInitReady', {
                    detail: this,
                } ) );
            }
        },
        initEvents() {
            // Initial state.
            this.prevVisibleItemCount = this.isotope.getFilteredItemElements().length;
            this.prevFilterString = this.getFilterString();

            // Check for changes.
            this.isotope.on( 'layoutComplete', () => {
                const currVisibleItemCount = this.isotope.getFilteredItemElements().length;
                const currFilterString = this.getFilterString();

                if ( currVisibleItemCount !== this.prevVisibleItemCount || currFilterString !== this.prevFilterString ) {
                    this.fireEvent( 'visibleItemsChanged' );

                    this.prevFilterString = currFilterString;
                }
            } );

            // Don't wait for animation to update visible item count.
            this.on( 'filter', () => {
                this.prevVisibleItemCount = this.isotope.getFilteredItemElements().length;
            });
        },
    }
};