import React, { Fragment } from 'react';

import Icon from 'Shared/Icon';

import FieldColor from './FieldColor';
import FieldColors from './FieldColors';
import FieldColumns from './FieldColumns';
import FieldDropdown from './FieldDropdown';
import FieldOrder from './FieldOrder';
import FieldRadio from './FieldRadio';
import FieldSlug from './FieldSlug';
import FieldFilter from './FieldFilter';
import FieldTinymce from './FieldTinymce';

const fields = {
    text: (props) => (
        <input
            type="text"
            value={props.value}
            placeholder={props.placeholder}
            onChange={(e) => {
                props.onChange(e.target.value);
            }}
        />
    ),
    number: (props) => (
        <Fragment>
            <input
                type="number"
                value={props.value}
                placeholder={props.placeholder}
                min={props.min}
                max={props.max}
                onChange={(e) => {
                    props.onChange(e.target.value);
                }}
            />
            {
                props.hasOwnProperty( 'suffix' )
                ?
                <span className="wpupg-admin-modal-field-number-suffix">{ props.suffix }</span>
                :
                null
            }
        </Fragment>
    ),
    textarea: (props) => (
        <textarea
            value={props.value}
            onChange={(e) => {
                props.onChange(e.target.value);
            }}
        />
    ),
    checkbox: (props) => (
        <input
            type="checkbox"
            checked={props.value}
            onChange={(e) => {
                props.onChange(e.target.checked);
            }}
        />
    ),
    color: (props) => (
        <FieldColor
            { ...props }
        />
    ),
    colors: (props) => (
        <FieldColors
            { ...props }
        />
    ),
    columns: (props) => (
        <FieldColumns
            { ...props }
        />
    ),
    dropdown: (props) => (
        <FieldDropdown
            { ...props }
        />
    ),
    order: (props) => (
        <FieldOrder
            { ...props }
        />
    ),
    radio: (props) => (
        <FieldRadio
            { ...props }
        />
    ),
    slug: (props) => (
        <FieldSlug
            { ...props }
        />
    ),
    filter: (props) => (
        <FieldFilter
            { ...props }
        />
    ),
    tinymce: (props) => (
        <FieldTinymce
            { ...props }
        />
    ),
    custom: (props) => (
        <Fragment>{ props.children }</Fragment>
    ),
}

const Field = (props) => {
    let helpIcon = null;
    if ( props.help ) {
        helpIcon = (
            <Icon
                type="question"
                title={ props.help }
                className="wpupg-admin-icon-help"
            />
        );
    }

    let field = null;
    if ( fields.hasOwnProperty( props.type) ) {
        field = fields[ props.type ];
    }

    return (
        <div className={`wpupg-admin-modal-field-container wpupg-admin-modal-field-container-${props.type}`}>
            <div className="wpupg-admin-modal-field-label">{ props.label }{ helpIcon }</div>
            <div className="wpupg-admin-modal-field">{ null !== field && field( props ) }</div>
        </div>
    );
}
export default Field;