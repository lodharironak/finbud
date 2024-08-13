import React from 'react';

import Icon from 'Shared/Icon';
import { __wpupg } from 'Shared/Translations';
import FieldDropdown from './FieldDropdown';
import FieldSlug from './FieldSlug';
 
const FieldFilter = (props) => {
    return (
        <div className="wpupg-admin-modal-field-filter">
            <FieldDropdown
                value={ props.value.type }
                onChange={ (value) => {
                    // Get options for this type.
                    let options = {};
                    if ( wpupg_admin_manage_modal.filters.hasOwnProperty( value ) ) {
                        options = wpupg_admin_manage_modal.filters[ value ];
                    }

                    props.onChange({
                        ...props.value,
                        options,
                        type: value,
                    });
                } }
                options={[
                    {
                        label: __wpupg( 'Filters' ),
                        options: [
                            { value: 'isotope', label: __wpupg( 'Isotope' ) },
                            { value: 'checkboxes', label: `${ __wpupg( 'Checkboxes' ) }${ wpupg_admin.addons.premium ? '' : ` (${__wpupg( 'Premium Only' ) })` }`, },
                            // { value: 'slider', label: `${ __wpupg( 'Slider' ) }${ wpupg_admin.addons.premium ? '' : ` (${__wpupg( 'Premium Only' ) })` }`, },
                            { value: 'dropdown', label: `${ __wpupg( 'Dropdown' ) }${ wpupg_admin.addons.premium ? '' : ` (${__wpupg( 'Premium Only' ) })` }`, },
                            { value: 'text_search', label: `${ __wpupg( 'Text Search' ) }${ wpupg_admin.addons.premium ? '' : ` (${__wpupg( 'Premium Only' ) })` }`, },
                        ],
                    },{
                        label: __wpupg( 'Other' ),
                        options: [
                            // { value: 'dynamic_order', label: `${ __wpupg( 'Dynamic Order' ) }${ wpupg_admin.addons.premium ? '' : ` (${__wpupg( 'Premium Only' ) })` }`, },
                            { value: 'clear', label: __wpupg( 'Clear Filter Selections Button' ) },
                        ],
                    },
                ]}
                width="215px"
            />
            <input
                className="wpupg-admin-modal-field-filter-label"
                type="text"
                value={ props.value.label }
                placeholder={ __wpupg( 'Optional Label' ) }
                onChange={(e) => {
                    props.onChange({
                        ...props.value,
                        label: e.target.value,
                    });
                }}
            />
            <FieldSlug
                className="wpupg-admin-modal-field-filter-id"
                value={ props.value.id }
                onChange={ (value) => {
                    props.onChange({
                        ...props.value,
                        id: value,
                    });
                } }
                placeholder={ __wpupg( 'Optional Identifier' ) }
            />
            <div className="wpupg-admin-modal-field-filter-order">
                <Icon
                    type="up"
                    className={ false === props.onClickUp ? 'wpupg-admin-modal-field-filter-order-disabled' : '' }
                    onClick={() => {
                        if ( false !== props.onClickUp ) {
                            props.onClickUp();
                        }
                    }}
                />
                <Icon
                    type="down"
                    className={ false === props.onClickDown ? 'wpupg-admin-modal-field-filter-order-disabled' : '' }
                    onClick={() => {
                        if ( false !== props.onClickDown ) {
                            props.onClickDown();
                        }
                    }}
                />
            </div>
            <div className="wpupg-admin-modal-field-filter-remove">
                <Icon
                    type="delete"
                    onClick={() => {
                        if ( confirm( __wpupg( 'Are you sure you want to remove this filter?' ) ) ) {
                            props.onChange( false );
                        }
                    }}
                />
            </div>
        </div>
    );
}
export default FieldFilter;
