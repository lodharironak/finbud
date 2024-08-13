import React, { Component } from 'react';
import AsyncSelect from 'react-select/async';

import Api from 'Shared/Api';

let defaultOptions = [];

export default class PreviewItem extends Component {
    getOptions(input) {
        if (!input) {
			return Promise.resolve({ options: [] });
        }

		return Api.template.searchItems(input)
            .then((data) => {
                return data;
            });
    }

    render() {
        return (
            <AsyncSelect
                className="wpupg-main-container-preview-item"
                placeholder="Search for an item to preview"
                value={this.props.item}
                onChange={(item) => {
                    // Remember selected item if not already remembered.
                    if ( -1 === defaultOptions.findIndex((option) => item.value === option.value ) ) {
                        defaultOptions.push(item);
                    }

                    this.props.onChange(item);
                }}
                loadOptions={this.getOptions.bind(this)}
                defaultOptions={ defaultOptions }
                noOptionsMessage={() => "No items found. Type to search!"}
                clearable={false}
            />
        );
    }
}