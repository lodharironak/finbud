import ReactDOM from 'react-dom';

const AddBlocks = (props) => {
    return ReactDOM.createPortal(
        props.children,
        document.getElementById( 'wpupg-add-blocks' )
      );
}

export default AddBlocks;