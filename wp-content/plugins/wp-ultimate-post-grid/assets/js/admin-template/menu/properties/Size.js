import React, { Component, Fragment } from 'react';

export default class PropertySize extends Component {
    constructor(props) {
        super(props);

        this.state = {
            number: '',
            unit: '',
        };
    }

    changeNumber(number) {
        if ( number !== this.state.number ) {
            this.props.onValueChange(`${number}${this.state.unit}`);
        }
    }

    changeUnit(unit) {
        if ( unit !== this.state.unit ) {
            this.props.onValueChange(`${this.state.number}${unit}`);
        }
    }

    componentDidMount() {
        this.checkNumber();
    }

    componentDidUpdate() {
        this.checkNumber();
    }

    checkNumber() {
        const split = this.props.value.match(/([+-]?\d*\.?\d*)\s*([^;]*)/);

        const number = split ? split[1] : '';
        const unit = split ? split[2] : '';

        if ( number !== this.state.number || unit !== this.state.unit ) {
            this.setState({
                number,
                unit,
            });
        }
    }

    render() {
        let unitOptions = ['px', 'em'];

        if ( this.state.unit && ! unitOptions.includes(this.state.unit) ) {
            unitOptions.push(this.state.unit);
        }

        return (
            <Fragment>
                <input
                    className="wpupg-template-property-input"
                    type="number"
                    step={ 'px' === this.state.unit ? '1' : '0.1' }
                    value={this.state.number}
                    onChange={(e) => this.changeNumber(e.target.value)}
                />
                {
                    unitOptions.map((unit, index) => (
                        <span
                            className={ unit === this.state.unit ? 'wpupg-template-property-value-size-unit wpupg-template-property-value-size-unit-selected' : 'wpupg-template-property-value-size-unit' }
                            onClick={() => this.changeUnit(unit)}
                            key={index}
                        >{unit}</span>
                    ))
                }
            </Fragment>
        );
    }
}