import React, { Fragment } from 'react';
const { hooks } = WPUltimatePostGrid['wp-ultimate-post-grid/dist/shared'];

import Field from 'Modal/field';
import { __wpupg } from 'Shared/Translations';
import PaginationPages from './PaginationPages';

const SectionPagination = (props) => {
    const paginationTypes = hooks.applyFilters( 'paginationTypes', {
        pages: PaginationPages,
    } );

    const PaginationBlock = paginationTypes.hasOwnProperty( props.grid.pagination_type ) ? paginationTypes[ props.grid.pagination_type ] : false;

    return (
        <Fragment>
            <Field
                value={ props.grid.pagination_type }
                onChange={ ( value ) => {
                    props.onGridChange({
                        pagination_type: value,
                    });
                }}
                type="dropdown"
                label={ __wpupg( 'Type' ) }
                options={[
                    {
                        value: 'none',
                        label: __wpupg( 'No pagination (all posts visible at once)' ),
                    },
                    {
                        value: 'pages',
                        label: __wpupg( 'Divide posts in pages' ),
                    },
                    {
                        value: 'infinite_load',
                        label: `${ __wpupg( 'Infinite Scroll Load' ) }${ wpupg_admin.addons.premium ? '' : ` (${__wpupg( 'Premium Only' ) })` }`,
                    },
                    {
                        value: 'load_more',
                        label: `${ __wpupg( 'Use a "Load More" button' ) }${ wpupg_admin.addons.premium ? '' : ` (${__wpupg( 'Premium Only' ) })` }`,
                    },
                    {
                        value: 'load_filter',
                        label: __wpupg( 'Load more posts on filter' ),
                        label: `${ __wpupg( 'Load more posts on filter' ) }${ wpupg_admin.addons.premium ? '' : ` (${__wpupg( 'Premium Only' ) })` }`,
                    },
                ]}
            />
            {
                'none' !== props.grid.pagination_type
                &&
                <Fragment>
                    {
                        false !== PaginationBlock
                        &&
                        <PaginationBlock
                            { ...props }
                            grid={ props.grid }
                            options={ props.grid.pagination[ props.grid.pagination_type ] }
                            onChange={ ( options ) => {
                                let newPagination = JSON.parse( JSON.stringify( props.grid.pagination ) );
                                newPagination[ props.grid.pagination_type ] = {
                                    ...newPagination[ props.grid.pagination_type ],
                                    ...options,
                                };

                                props.onGridChange({
                                    pagination: newPagination,
                                });
                            }}
                        />
                    }
                </Fragment>
            }
        </Fragment>
    );
}
export default SectionPagination;
