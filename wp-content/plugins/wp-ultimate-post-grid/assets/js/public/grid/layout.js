export default ( elemId, args ) => {
    return {
        forcingHeight: false,
        forceHeight() {
            if ( ! this.forcingHeight ) {
                this.forcingHeight = true;

                const rows = this.getVisibleItemsPerRow();
                let changesMade = false;

                for ( let row of rows ) {
                    let heights = [];

                    for ( let item of row ) {
                        const currentHeight = item.style.height;

                        // Get item heights, without height set.
                        item.style.height = '';
                        heights.push( item.offsetHeight );

                        // Reset to current height.
                        item.style.height = currentHeight;
                    }

                    const maxHeight = Math.max( ...heights );

                    // If an item is not the same size, resize.
                    for ( let item of row ) {
                        const itemHeight = item.offsetHeight;

                        if ( itemHeight !== maxHeight ) {
                            changesMade = true;

                            item.style.height = `${ maxHeight }px`;
                            item.animate(
                                [{ height: `${ itemHeight }px` }, { height: `${ maxHeight }px` } ],
                                300
                            );
                        }
                    }
                }

                // Wait until animations are done.
                setTimeout(() => {
                    // Relayout if changes were made.
                    if ( changesMade ) {
                        this.layout();
                    }

                    this.forcingHeight = false;
                }, 400);
            }
        },
        getVisibleItemsPerRow() {
            const visibleItems = this.isotope.getFilteredItemElements();

            let currentRowTop = 0;
            let currentRow = [];
            let rows = [];

            for ( let item of visibleItems ) {
                if ( currentRowTop < item.offsetTop ) {
                    // Item is on a new row.
                    if ( 0 < currentRow.length ) {
                        rows.push( currentRow );
                    }

                    currentRow = [];
                    currentRowTop = item.offsetTop;
                }

                // Add item to current row.
                currentRow.push( item );
            }

            // Make sure to add last row.
            if ( 0 < currentRow.length ) {
                rows.push( currentRow );
            }

            return rows;
        },
        initLayout() {
            if ( args.hasOwnProperty( 'force_height' ) && args.force_height ) {
                this.isotope.on( 'layoutComplete', () => {
                    this.forceHeight();
                } );
            }
        },
    }
};