import React from 'react';
import SVG from 'react-inlinesvg';

import '../../css/admin/shared/icon.scss';
import Tooltip from './Tooltip';

import IconClipboard from '../../icons/clipboard.svg';
import IconClose from '../../icons/close.svg';
import IconDelete from '../../icons/delete.svg';
import IconDown from '../../icons/down.svg';
import IconDuplicate from '../../icons/duplicate.svg';
import IconEdit from '../../icons/edit.svg';
import IconLink from '../../icons/link.svg';
import IconQuestion from '../../icons/question.svg';
import IconReload from '../../icons/reload.svg';
import IconUp from '../../icons/up.svg';
 
const icons = {
    clipboard: IconClipboard,
    close: IconClose,
    delete: IconDelete,
    down: IconDown,
    duplicate: IconDuplicate,
    edit: IconEdit,
    link: IconLink,
    question: IconQuestion,
    reload: IconReload,
    up: IconUp,
};

const Icon = (props) => {
    let icon = icons.hasOwnProperty(props.type) ? icons[props.type] : false;

    if ( !icon ) {
        return null;
    }

    let iconDisabled = false;
    let tooltipContent = props.title ? props.title : false;
    let className = props.className ? `wpupg-admin-icon ${props.className}` : 'wpupg-admin-icon';

    // Check if there are requirements.
    if ( props.required ) {
        if ( ! wpupg_admin.addons.hasOwnProperty( props.required ) || true !== wpupg_admin.addons[ props.required ] ) {
            iconDisabled = true;
            className += ' wpupg-admin-icon-required';

            const capitalized = props.required[0].toUpperCase() + props.required.substring(1);
            tooltipContent = `WP Ultimate Post Grid ${capitalized} Bundle Only`;
        }
    }

    return (
        <Tooltip content={tooltipContent}>
            <span
                className={className}
                onClick={ iconDisabled ? () => {
                    if ( confirm( 'Want to learn more about the version required for this feature?' ) ) {
                        window.open( 'https://bootstrapped.ventures/wp-ultimate-post-grid/get-the-plugin/', '_blank' );
                    } 
                } : props.onClick }
                title={props.title}
            >
                <SVG
                    src={icon}
                />
            </span>
        </Tooltip>
    );
}
export default Icon;