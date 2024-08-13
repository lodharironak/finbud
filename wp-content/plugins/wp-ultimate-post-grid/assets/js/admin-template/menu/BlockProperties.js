import ReactDOM from 'react-dom';

const BlockProperties = (props) => {
    return ReactDOM.createPortal(
        props.children,
        document.getElementById( 'wpupg-block-properties' )
      );
}

export default BlockProperties;