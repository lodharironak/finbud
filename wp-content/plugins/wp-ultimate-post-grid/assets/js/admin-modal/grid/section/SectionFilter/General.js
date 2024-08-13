import React, { Fragment } from 'react';

import EditMode from 'Modal/general/EditMode';
import Field from 'Modal/field';
import { __wpupg } from 'Shared/Translations';

import GeneralStyle from './GeneralStyle';
import LabelStyle from './LabelStyle';
import FiltersResponsive from './FiltersResponsive';

const General = (props) => {
    let modes = {
        filters: {
            label: __wpupg( 'Filters' ),
            block: (
                <Fragment>
                    <Field
                        value={ props.grid.filters_enabled }
                        onChange={ ( value ) => {
                            // Set default filter when enabling.
                            let filters = false;
                            if ( 0 === props.grid.filters.length ) {
                                filters = [
                                    {
                                        id: '',
                                        label: '',
                                        type: 'isotope',
                                        options: wpupg_admin_manage_modal.filters['isotope'],
                                    }
                                ];
                            }

                            if ( filters ) {
                                props.onGridChange({
                                    filters,
                                    filters_enabled: value,
                                });
                            } else {
                                props.onGridChange({
                                    filters_enabled: value,
                                });
                            }
                        }}
                        type="checkbox"
                        label={ __wpupg( 'Enable Filtering' ) }
                    />
                    {
                        props.grid.filters_enabled
                        &&
                        <Fragment>
                            {
                                props.grid.filters.map((filter, index) => (
                                    <Field
                                        value={ filter }
                                        onChange={ ( value ) => {
                                            let newFilters = JSON.parse( JSON.stringify( props.grid.filters ) );
        
                                            if ( false === value ) {
                                                newFilters.splice( index, 1 );
                                            } else {
                                                newFilters[ index ] = value;
                                            }
         
                                            props.onGridChange({
                                                filters: newFilters,
                                            });
                                        }}
                                        type="filter"
                                        label={ `${__wpupg( 'Filter' )} #${ index + 1 }` }
                                        onClickUp={
                                            0 === index
                                            ?
                                            false
                                            :
                                            () => {
                                                let newFilters = JSON.parse( JSON.stringify( props.grid.filters ) );
                                                newFilters.splice( index - 1, 0, newFilters.splice( index, 1 )[0] );
            
                                                props.onGridChange({
                                                    filters: newFilters,
                                                });
                                            }
                                        }
                                        onClickDown={
                                            props.grid.filters.length - 1 === index
                                            ?
                                            false
                                            :
                                            () => {
                                                let newFilters = JSON.parse( JSON.stringify( props.grid.filters ) );
                                                newFilters.splice( index + 1, 0, newFilters.splice( index, 1 )[0] );
            
                                                props.onGridChange({
                                                    filters: newFilters,
                                                });
                                            }
                                        }
                                        key={ index }
                                    />
                                ))
                            }
                            <Field
                                type="custom"
                            >
                                <a
                                    href="#"
                                    onClick={(e) => {
                                        e.preventDefault();
                                        let newFilters = JSON.parse( JSON.stringify( props.grid.filters ) );
                                        newFilters.push({
                                            id: '',
                                            type: 'isotope',
                                            options: wpupg_admin_manage_modal.filters['isotope'],
                                        });

                                        props.onGridChange({
                                            filters: newFilters,
                                        });
                                    }}
                                >{ __wpupg( 'Add Filter' ) }</a>
                            </Field>
                            {
                                2 <= props.grid.filters.length
                                &&
                                <Field
                                    value={ props.grid.filters_relation }
                                    onChange={ ( value ) => { props.onGridChange({ filters_relation: value }); }}
                                    type="dropdown"
                                    options={[
                                        {
                                            value: 'AND',
                                            label: __wpupg( 'Only posts that match all of the filters (AND)' ),
                                        },
                                        {
                                            value: 'OR',
                                            label: __wpupg( 'All posts that match any of the filters (OR)' ),
                                        }
                                    ]}
                                    label={ __wpupg( 'Filters Relation' ) }
                                />
                            }
                        </Fragment> 
                    }
                </Fragment>
            ),
        },
    };

    if ( props.grid.filters_enabled && 0 < props.grid.filters.length ) {
        modes['filters_style'] = {
            label: __wpupg( 'Filters Style' ),
            block: (
                <GeneralStyle
                    style={ props.grid.filters_style }
                    onChange={ (option) => {
                        props.onGridChange({
                            filters_style: {
                                ...props.grid.filters_style,
                                ...option,
                            }
                        });
                    }}
                />
            ),
        }

        modes['label_style'] = {
            label: __wpupg( 'Labels Style' ),
            block: (
                <LabelStyle
                    style={ props.grid.filters_style }
                    onChange={ (option) => {
                        props.onGridChange({
                            filters_style: {
                                ...props.grid.filters_style,
                                ...option,
                            }
                        });
                    }}
                />
            ),
        }

        modes['filters_responsive'] = {
            label: __wpupg( 'Display Filters' ),
            block: (
                <FiltersResponsive
                    grid={ props.grid }
                    onChange={ ( options ) => {
                        props.onGridChange({
                            ...options,
                        });
                    }}
                />
            ),
        }
    }

    return (
        <EditMode
            modes={ modes }
        />
    );
}
export default General;
