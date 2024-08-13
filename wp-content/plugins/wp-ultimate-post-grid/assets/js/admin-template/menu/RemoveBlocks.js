import ReactDOM from 'react-dom';

const RemoveBlocks = (props) => {
    return ReactDOM.createPortal(
        props.children,
        document.getElementById( 'wpupg-remove-blocks' )
      );
}

export default RemoveBlocks;