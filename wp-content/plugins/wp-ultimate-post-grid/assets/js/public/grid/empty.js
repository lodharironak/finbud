import { slideDown, slideUp, slideStop } from 'slide-anim';

export default ( elemId, args ) => {
    return {
        isEmpty: false,
        hideEmpty( temporary = false ) {
            const emptyElem = document.querySelector( '#' + this.elemId + '-empty' );

            if ( emptyElem ) {
                if ( temporary ) {
                    if ( ! this.isEmpty ) {
                        emptyElem.style.visibility = 'hidden';
                    }
                } else {
                    slideStop( emptyElem );
                    slideUp( emptyElem );
                }
            }
        },
        checkEmpty() {
            const emptyElem = document.querySelector( '#' + this.elemId + '-empty' );

            if ( emptyElem ) {
                // Revert optional temporary hide.
                emptyElem.style.visibility = 'visible';

                // Check if should show or not.
                const visibleItems = this.isotope.getFilteredItemElements();

                if ( 0 === visibleItems.length && ! this.isEmpty ) {
                    slideStop( emptyElem );
                    slideDown( emptyElem );
                    this.isEmpty = true;
                } else if ( 0 < visibleItems.length && this.isEmpty ) {
                    this.hideEmpty();
                    this.isEmpty = false;
                }
            }
        },
        initEmpty() {
            this.on( 'initReady', () => {
                this.checkEmpty();
            });

            this.on( 'visibleItemsChanged', () => {
                this.checkEmpty();
            });
        }
    }
};