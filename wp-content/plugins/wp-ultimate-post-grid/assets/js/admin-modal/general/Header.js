import React from 'react';

import { __wpupg } from 'Shared/Translations';
import Icon from 'Shared/Icon';
 
const Header = (props) => {
    return (
        <div className="wpupg-admin-modal-header">
            <h2>{ props.children }</h2>
            <div
                className="wpupg-admin-modal-close"
                onClick={props.onCloseModal}
            >
                <Icon
                    type="close"
                    title={ __wpupg( 'Close' ) }
                />
            </div>
        </div>
    );
}
export default Header;