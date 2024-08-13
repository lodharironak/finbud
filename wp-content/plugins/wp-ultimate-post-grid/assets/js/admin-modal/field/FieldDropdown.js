import React, { Component } from 'react';
import Select from 'react-select';
import CreatableSelect from 'react-select/creatable';

export default class FieldDropdown extends Component {
    shouldComponentUpdate(nextProps) {
        return JSON.stringify(this.props.options) !== JSON.stringify(nextProps.options) || this.props.value !== nextProps.value || this.props.isDisabled !== nextProps.isDisabled;
    }

    render() {
        const isMulti = this.props.isMulti ? this.props.isMulti : false;
        let selectedOption = false;

        if ( this.props.options ) {
            const allOptions = this.props.options.reduce((acc, cur) => {
                if ( cur.hasOwnProperty('options') ) {
                    acc = acc.concat( cur.options );
                } else {
                    acc.push(cur);
                }
        
                return acc;
            }, []);

            if ( isMulti ) {
                selectedOption = allOptions.filter(({value}) => this.props.value.includes(value))
            } else {
                selectedOption = allOptions.find((option) => option.value === this.props.value);
            }
        }

        const customProps = this.props.custom ? this.props.custom : {};
        const SelectElem = this.props.creatable ? CreatableSelect : Select;

        return (
            <SelectElem
                isMulti={ isMulti }
                isDisabled={ this.props.isDisabled }
                options={this.props.options}
                value={selectedOption}
                placeholder={this.props.placeholder}
                onChange={(option) => {
                    if ( isMulti ) {
                        if ( null === option ) {
                            this.props.onChange([]);
                        } else {
                            const selected = Array.isArray(option) ? option : [option];
                            this.props.onChange(selected.map(option => option.value));
                        }
                    } else {
                        this.props.onChange(option.value);
                    }
                }}
                styles={{
                    control: (provided) => ({
                        ...provided,
                        backgroundColor: 'white',
                    }),
                    container: (provided) => ({
                        ...provided,
                        width: '100%',
                        maxWidth: this.props.width ? this.props.width : '600px',
                    }),
                }}
                { ...customProps }
            />
        );
    }
}