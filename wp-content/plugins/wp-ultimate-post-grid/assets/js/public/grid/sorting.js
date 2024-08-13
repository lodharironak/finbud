export default ( elemId, args ) => {
    return {
        order: args.order,
        setOrder( order ) {
            if ( JSON.stringify( order ) !== JSON.stringify( this.order ) ) {
                this.order = order;
                // TODO.
            }
        },
        getSortedOrder( items ) {
            // Check what sorting method is used.
            const sorting = this.args.isotope.getSortData.default.split( ' ' );

            let parseFunction = false;
            if ( 2 === sorting.length ) {
                switch ( sorting[1] ) {
                    case 'parseInt':
                        parseFunction = 'parseInt';
                        break;
                    case 'parseFloat':
                        parseFunction = 'parseFloat';
                        break;
                }
            }

            // Get the values to sort.
            let valuesToSort = [];

            for ( let i = 0; i < items.length; i++ ) {
                let item = items[ i ];
                let value = item.dataset.orderDefault;

                if ( 'parseInt' === parseFunction ) {
                    value = parseInt( value );
                } else if ( 'parseFloat' === parseFunction ) {
                    value = parseFloat( value );
                }
                
                valuesToSort.push({
                    index: i,
                    value,
                });
            }

            // Sort values.
            valuesToSort.sort((a, b) => {
                if ( false === parseFunction ) {
                    return a.value.localeCompare( b.value );
                } else {
                    return a.value - b.value;
                }
            });

            // Reverse if descending.
            if ( ! this.args.isotope.sortAscending ) {
                valuesToSort.reverse();
            }

            return valuesToSort.map((a) => a.index);
        },
    }
};