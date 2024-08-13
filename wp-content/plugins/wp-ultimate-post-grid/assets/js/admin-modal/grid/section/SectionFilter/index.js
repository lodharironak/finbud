import React, { Fragment } from 'react';
const { hooks } = WPUltimatePostGrid['wp-ultimate-post-grid/dist/shared'];

import EditMode from 'Modal/general/EditMode';
import { __wpupg } from 'Shared/Translations';
import General from './General';

import FilterClear from './FilterClear';
import FilterIsotope from './FilterIsotope';

const SectionFilter = (props) => {
    const filterTypes = hooks.applyFilters( 'filterTypes', {
        clear: FilterClear,
        isotope: FilterIsotope,
    } );

    let modes = {
        general: {
            label: __wpupg( 'General' ),
            block: (
                <General
                    { ...props }
                />
            ),
        },
    };

    if ( props.grid.filters_enabled ) {
        for ( let i = 0; i < props.grid.filters.length; i++ ) {
            const filter = props.grid.filters[ i ];
            const FilterBlock = filterTypes.hasOwnProperty( filter.type ) ? filterTypes[ filter.type ] : false;

            // Merge options with defaults.
            let options = filter.options;
            if ( wpupg_admin_manage_modal.filters.hasOwnProperty( filter.type ) ) {
                options = {
                    ...wpupg_admin_manage_modal.filters[ filter.type ],
                    ...filter.options,
                };
            }

            modes[ `filter-${i}` ] = {
                label: `${__wpupg( 'Filter' )} #${ i + 1 }${ filter.id ? ` - ${ filter.id }` : '' }`,
                block: (
                    <Fragment>
                        {
                            false == FilterBlock
                            ?
                            <p style={ { color: 'darkred' } }>
                                { __wpupg( 'This filter is only available in' ) } <a href="https://bootstrapped.ventures/wp-ultimate-post-grid/get-the-plugin/">WP Ultimate Post Grid Premium</a>.
                            </p>
                            :
                            <FilterBlock
                                grid={ props.grid }
                                options={ options }
                                onChange={ ( options ) => {
                                    let newFilters = JSON.parse( JSON.stringify( props.grid.filters ) );
                                    newFilters[ i ].options = {
                                        ...newFilters[ i ].options,
                                        ...options,
                                    };

                                    props.onGridChange({
                                        filters: newFilters,
                                    });
                                }}
                            />
                        }
                    </Fragment>
                ),
            }
        }
    }

    return (
        <EditMode
            modes={ modes }
        />
    );
}
export default SectionFilter;
