import React, { Component, Fragment } from 'react';

import Api from 'Shared/Api';
import Loader from 'Shared/Loader';
import { __wpupg } from 'Shared/Translations';
import FieldDropdown from '../field/FieldDropdown';

// const SelectGrid = (props) => {
//     let gridOptions = [];

//     for ( let grid of wpupg_admin.grids ) {
//         gridOptions.push({
//             value: grid.slug,
//             label: `${ grid.id } - ${ grid.name || 'n/a' }`,
//         });
//     }
//     return (

//     );
// }
// export default SelectGrid;


export default class SelectFilter extends Component {
    constructor(props) {
        super(props);
    
        this.state = {
            grid: props.grid,
            filters: [],
            loading: false,
        };
    }

    componentDidMount() {
        this.loadFilters( this.state.grid );
    }

    componentDidUpdate() {
        if ( this.state.grid !== this.props.grid ) {
            this.loadFilters( this.props.grid );
        }
    }

    loadFilters( grid ) {
        if ( false === grid ) {
            this.setState({
                grid: false,
                loading: false,
            });
        } else {
            this.setState({
                grid,
                loading: true,
            }, () => {
                let selectedGrid = wpupg_admin.grids.find( (g) => g.slug === grid );

                if ( selectedGrid ) {
                    Api.grid.get( selectedGrid.id ).then((data) => {
                        let filters = [];

                        if ( data && data.grid.filters_enabled ) {
                            for ( let i = 0; i < data.grid.filters.length; i++  ) {
                                let filter = data.grid.filters[i];
                                const slug = filter.id ? filter.id : i + 1;

                                filters.push({
                                    value: slug,
                                    label: `${__wpupg( 'Filter' )} #${ i + 1 }${ filter.id ? ` - ${ filter.id }` : '' }`
                                });
                            }
                        }

                        // Only if the state grid hasn't changed in the meantime.
                        if ( grid === this.state.grid ) {
                            this.setState({
                                filters,
                                loading: false,
                            });
                        }
                    });
                }
            });
        }
    }

    render() {
        let filterOptions = [
            {
                value: true,
                label: __wpupg( 'Display all Filters' ),
            },
            ...this.state.filters,
        ];

        return (
            <Fragment>
                {
                    this.state.loading
                    ?
                    <Loader />
                    :
                    <Fragment>
                    {
                        false === this.state.grid
                        ?
                        null
                        :
                        <FieldDropdown
                            placeholder={ this.props.placeholder }
                            value={ this.props.value }
                            onChange={ this.props.onChange }
                            options={ filterOptions }
                        />
                    }
                    </Fragment>
                }
            </Fragment>
        )
    }
}