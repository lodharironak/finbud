import React, { Fragment } from 'react';

import Field from 'Modal/field';
import FieldDropdown from 'Modal/field/FieldDropdown';
import { __wpupg } from 'Shared/Translations';

import '../../../../../css/admin/modal/custom/responsive.scss';

const FiltersResponsive = (props) => {
    const displaySizes = [
        { value: 'desktop', label: __wpupg( 'Desktop' ) },
        { value: 'tablet', label: __wpupg( 'Tablet' ) },
        { value: 'mobile', label: __wpupg( 'Mobile' ) },
    ];
    const displayOptions = [
        { value: 'show', label: __wpupg( 'Show' ) },
        { value: 'toggle_closed', label: __wpupg( 'Toggle (Closed)' ) },
        { value: 'toggle_open', label: __wpupg( 'Toggle (Open)' ) },
        { value: 'hide', label: __wpupg( 'Hide' ) },
    ];

    let usingToggle = false;

    return (
        <Fragment>
            <Field
                type="custom"
            >
                <div className="wpupg-admin-modal-field-filter-responsive-header">
                    {
                        displaySizes.map((size, sizeIndex) => (
                            <div
                                className="wpupg-admin-modal-field-filter-responsive-header-size"
                                key={ sizeIndex }
                            >{ size.label }</div>
                        ))
                    }
                    <div
                        className="wpupg-admin-modal-field-filter-responsive-header-size"
                    >{ __wpupg( 'Label' ) }</div>
                </div>
            </Field>
            {
                props.grid.filters.map((filter, filterIndex) => (
                    <Field
                        label={ `${__wpupg( 'Filter' )} #${ filterIndex + 1 }${ filter.id ? ` - ${ filter.id }` : '' }` }
                        type="custom"
                        key={ filterIndex }
                    >
                        <div className="wpupg-admin-modal-field-filter-responsive">
                            {
                                displaySizes.map((size, sizeIndex) => {
                                    const displayOption = filter.options.responsive[ size.value ];

                                    if ( 'toggle' === displayOption.substr(0, 6) ) {
                                        usingToggle = true;
                                    }

                                    return (
                                        <div
                                            className="wpupg-admin-modal-field-filter-responsive-size"
                                            key={ sizeIndex }
                                        >
                                            <FieldDropdown
                                                value={ displayOption }
                                                onChange={ (value) => {
                                                    let newFilters = JSON.parse( JSON.stringify( props.grid.filters ) );
                                                    newFilters[ filterIndex ].options.responsive[ size.value ] = value;

                                                    props.onChange( {
                                                        filters: newFilters,
                                                    } );
                                                } }
                                                options={ displayOptions }
                                                width="140px"
                                            />
                                        </div>
                                    );
                                })
                            }
                            <div className="wpupg-admin-modal-field-filter-responsive-size">
                                <input
                                    className="wpupg-admin-modal-field-filter-label"
                                    type="text"
                                    value={ filter.label }
                                    onChange={(e) => {
                                        let newFilters = JSON.parse( JSON.stringify( props.grid.filters ) );
                                        newFilters[ filterIndex ].label = e.target.value;

                                        props.onChange( {
                                            filters: newFilters,
                                        } );
                                    }}
                                />
                            </div>
                        </div>
                    </Field>
                ))
            }
            {
                usingToggle
                &&
                <Fragment>
                    <Field
                        value={ props.grid.responsive_toggle_style }
                        onChange={ ( value ) => {
                            props.onChange({
                                responsive_toggle_style: value,
                            });
                        }}
                        type="dropdown"
                        options={[
                            {
                                value: 'arrow',
                                label: __wpupg( 'Arrows' ),
                            },
                            {
                                value: 'triangle',
                                label: __wpupg( 'Triangles' ),
                            },
                            {
                                value: 'plus',
                                label: __wpupg( 'Plus & Minus' ),
                            },
                            {
                                value: 'custom',
                                label: __wpupg( 'Custom Text' ),
                            }
                        ]}
                        label={ __wpupg( 'Toggle Style' ) }
                    />
                    {
                        'custom' === props.grid.responsive_toggle_style
                        &&
                        <div className="wpupg-admin-modal-field-filter-responsive-toggle-text">
                            <Field
                                value={ props.grid.responsive_toggle_style_closed }
                                onChange={ ( value ) => {
                                    props.onChange({
                                        responsive_toggle_style_closed: value,
                                    });
                                }}
                                type="text"
                                label={ __wpupg( 'Toggle Closed Text' ) }
                            />
                            <Field
                                value={ props.grid.responsive_toggle_style_open }
                                onChange={ ( value ) => {
                                    props.onChange({
                                        responsive_toggle_style_open: value,
                                    });
                                }}
                                type="text"
                                label={ __wpupg( 'Toggle Open Text' ) }
                            />
                        </div>
                    }
                </Fragment>
            }
        </Fragment>
    );
}
export default FiltersResponsive;
