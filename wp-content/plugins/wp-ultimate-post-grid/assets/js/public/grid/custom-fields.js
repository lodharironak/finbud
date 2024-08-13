export default ( elemId, args ) => {
    return {
        getCustomFieldSelectors( selected, args ) {
            let selectors = [];
            const selectedValues = selected.hasOwnProperty( args.custom_field ) ? selected[ args.custom_field ] : [];

            for ( let i = 0; i < selectedValues.length; i++ ) {
                const items = this.elem.querySelectorAll( '.wpupg-item' );
                const dataKey = 'data-wpupg-cf-' + args.custom_field;
                const classSelector = 'wpupg-cf-filter-' + args.id + '-' + i;

                // Value to test.
                const valueToTest = this.getCustomFieldTestValue( selectedValues[i], args );

                for ( let item of items ) {
                    item.classList.remove( classSelector );
                    let itemValue = item.getAttribute( dataKey );

                    if ( null === itemValue ) {
                        continue;
                    }

                    // Maybe convert to number.
                    if ( 'number' === valueToTest.type || 'range' === valueToTest.type ) {
                        itemValue = itemValue.replace( ',', '.' );
                        itemValue = parseFloat( itemValue );
                    }

                    // Add class if matches this filter.
                    if ( 'range' !== valueToTest.type ) {
                        if ( 'fuzzy' === valueToTest.type ) {
                            // Fuzzy matching.
                            if ( itemValue.indexOf( valueToTest.value ) !== -1 ) {
                                item.classList.add( classSelector );
                            }
                        } else {
                            // Exact match only.
                            if ( itemValue === valueToTest.value ) {
                                item.classList.add( classSelector );
                            }
                        }
                    } else {
                        if ( valueToTest.value[0] <= itemValue && itemValue <= valueToTest.value[1] ) {
                            item.classList.add( classSelector );
                        }
                    }
                }

                selectors.push( '.' + classSelector );
            }

            return selectors;
        },
        getCustomFieldQueryArgs( selected, args ) {
            let values = [];
            const selectedValues = selected.hasOwnProperty( args.custom_field ) ? selected[ args.custom_field ] : [];

            for ( let selectedValue of selectedValues ) {
                values.push( this.getCustomFieldTestValue( selectedValue, args ) );
            }

            return {
                'type': 'custom_field',
                'custom_field': args.custom_field,
                'values': values,
                'values_inverse': args.inverse,
                'values_relation': 'match_all' === args.multiselect_type ? 'AND' : 'OR',
            };
        },
        getCustomFieldTestValue( value, args ) {
            let valueToTest = {
                type: 'string',
                value: value,
            };

            if ( args.custom_field_numeric ) {
                valueToTest.value = valueToTest.value.replace( ',', '.' );

                if ( -1 === valueToTest.value.indexOf( '-' ) ) {
                    valueToTest.type = 'number';
                    valueToTest.value = parseFloat( valueToTest.value );
                } else {
                    let rangeValues = valueToTest.value.split( '-' );

                    valueToTest.type = 'range';
                    valueToTest.value = [
                        parseFloat( rangeValues[0] ),
                        parseFloat( rangeValues[1] ),
                    ];
                }
            } else if ( args.custom_field_fuzzy ) {
                valueToTest.type = 'fuzzy';
            }

            return valueToTest;
        },
    }
};