import React, { Component, Fragment } from 'react';
import Parser from 'html-react-parser';

import '../../../../../../wp-ultimate-post-grid/assets/css/template/template_reset.scss';
import '../../../../../../wp-ultimate-post-grid/assets/css/template/shortcodes.scss';

import Helpers from '../../general/Helpers';
import Loader from 'Shared/Loader';
import Block from './Block';
import AddBlocks from '../../menu/AddBlocks';
import RemoveBlocks from '../../menu/RemoveBlocks';
import BlockProperties from '../../menu/BlockProperties';
import PreviewItem from './PreviewItem';

// Sort shortcodes for "Add Blocks" section.
const generalShortcodeKeys = [
    'wpupg-spacer',
    'wpupg-text',
    'wpupg-link',
    'wpupg-image',
    'wpupg-icon',
];
let gridShortcodeKeys = [];
let recipeShortcodeKeys = [];
const shortcodeKeysAlphebetically = Object.keys(wpupg_admin_template.shortcodes).sort();

for ( let shortcode of shortcodeKeysAlphebetically ) {
    if ( ! generalShortcodeKeys.includes( shortcode ) ) {
        if ( 'wpupg' === shortcode.substr(0,5) ) {
            gridShortcodeKeys.push( shortcode );
        } else {
            recipeShortcodeKeys.push( shortcode );
        }
    }
}

export default class PreviewTemplate extends Component {
    constructor(props) {
        super(props);

        let item = wpupg_admin_template.preview_item;

        this.state = {
            item,
            width: 300,
            html: '',
            htmlMap: '',
            parsedHtml: '',
            shortcodes: [],
            editingBlock: false,
            addingBlock: false,
            hoveringBlock: false,
            hasError: false,
        }

        this.previewItem = React.createRef();
    }

    componentDidCatch() {
        this.setState({
            hasError: true,
        });
    }

    componentDidMount() {
        this.checkHtmlChange();
    }

    componentDidUpdate(prevProps) {
        // If changing to edit blocks mode, reset the editing blocks.
        if ( 'blocks' === this.props.mode && this.props.mode !== prevProps.mode ) {
            this.onChangeEditingBlock(false);
        } else {
            this.checkHtmlChange(); // onChangeEditingBlock forces HTML update, so no need to check.
        }
    }

    checkHtmlChange() {
        if ( this.props.template.html !== this.state.html ) {
            this.changeHtml();
        }
    }

    changeHtml() {
        const parsed = this.parseHtml(this.props.template.html);

        this.setState({
            html: this.props.template.html,
            htmlMap: parsed.htmlMap,
            parsedHtml: parsed.html,
            shortcodes: parsed.shortcodes,
            hasError: false,
        });
    }

    parseHtml(html) {
        let htmlToParse = html;

        // Remove closing wpupg-condition shortcode from preview.
        htmlToParse = htmlToParse.replace( /\[\/wpupg\-condition\]/g, '' );

        // Find shortcodes in HTML.
        let shortcodes = [];
        const regex = /\[([^\s\]]*)\s*([^\]]*?)\]/gmi;

        let match;
        while ((match = regex.exec(html)) !== null) {
            // Check for attributes in shortcode.
            let shortcode_atts = {};
            let attributes = match[2].match(/(\w+=\"[^\"]*?\"|\w+=\'[^\']*?\'|\w+=\w*)/gmi);

            if (attributes) {
                for (let i = 0; i < attributes.length; i++) {
                    let attribute = attributes[i];
                    let property = attribute.substring(0, attribute.indexOf('='));
                    let value = attribute.substring(attribute.indexOf('=') + 1);

                    // Trim value if necessary.
                    if ('"' === value[0] || "'" === value[0] ) {
                        value = value.substr(1, value.length-2);
                    }

                    shortcode_atts[property] = value;
                }
            }

            // Get shortcode name.
            let id = match[1];
            const name = Helpers.getShortcodeName(id);

            // Generate UID.
            let uid = shortcodes.length;

            // Replace with HTML tag to parse in next step, save attributes for access.
            htmlToParse = htmlToParse.replace(match[0], '<wpupg-replace-shortcode-with-block uid="' + uid + '"></wpupg-replace-shortcode-with-block>');
            shortcodes.push({
                uid,
                id,
                name,
                attributes: shortcode_atts,
            });
        }

        // Get HTML with shortcodes replaced by blocks.
        let parsedHtml = <Loader/>;
        try {
            parsedHtml = Parser(htmlToParse, {
                replace: function(domNode) {
                    if (domNode.name == 'wpupg-replace-shortcode-with-block') {    
                        return <Block
                            item={ this.state.item ? this.state.item.value : false }
                            shortcode={ shortcodes[ domNode.attribs.uid ] }
                            shortcodes={ shortcodes }
                            onBlockPropertyChange={ this.onBlockPropertyChange.bind(this) }
                            onBlockPropertiesChange={ this.onBlockPropertiesChange.bind(this) }
                            editingBlock={this.state.editingBlock}
                            onChangeEditingBlock={this.onChangeEditingBlock.bind(this)}
                            hoveringBlock={this.state.hoveringBlock}
                            onChangeHoveringBlock={this.onChangeHoveringBlock.bind(this)}
                        />;
                    }
                }.bind(this)
            });
        } catch ( error ) {}

        return {
            htmlMap: htmlToParse,
            html: parsedHtml,
            shortcodes,
        }
    }

    unparseHtml() {
        let html = this.state.htmlMap;

        for ( let shortcode of this.state.shortcodes ) {
            let fullShortcode = Helpers.getFullShortcode(shortcode);
            html = html.replace('<wpupg-replace-shortcode-with-block uid="' + shortcode.uid + '"></wpupg-replace-shortcode-with-block>', fullShortcode);
        }

        return html;
    }

    onBlockPropertyChange(uid, property, value) {
        let properties = {};
        properties[property] = value;
        this.onBlockPropertiesChange(uid, properties);
    }

    onBlockPropertiesChange(uid, properties) {
        let newState = this.state;
        newState.shortcodes[uid].attributes = {
            ...newState.shortcodes[uid].attributes,
            ...properties,
        }

        this.setState(newState,
            () => {
                let newHtml = this.unparseHtml();
                this.props.onChangeHTML(newHtml);
            });
    }

    onChangeEditingBlock(uid) {
        if (uid !== this.state.editingBlock) {
            this.setState({
                editingBlock: uid,
                hoveringBlock: false,
            }, this.changeHtml);
            // Force HTML update to trickle down editingBlock prop.
        }
    }

    onChangeHoveringBlock(uid) {
        if (uid !== this.state.hoveringBlock) {
            this.setState({
                hoveringBlock: uid,
            }, this.changeHtml);
            // Force HTML update to trickle down hoveringBlock prop.
        }
    }

    onChangeAddingBlock(id) {
        if (id !== this.state.addingBlock) {
            this.setState({
                addingBlock: id,
            });
        }
    }

    onAddBlockAfter(uid) {
        let htmlMap = this.state.htmlMap;
        const shortcode = '[' + this.state.addingBlock + ']';
        const afterShortcode = '<wpupg-replace-shortcode-with-block uid="' + uid + '"></wpupg-replace-shortcode-with-block>';
        htmlMap = htmlMap.replace(afterShortcode, afterShortcode + '\n' + shortcode);

        if ( htmlMap !== this.state.htmlMap) {
            this.setState({
                addingBlock: false,
                hoveringBlock: false,
                htmlMap,
            },
                () => {
                    let newHtml = this.unparseHtml();
                    this.props.onChangeHTML(newHtml);
                    this.props.onChangeMode( 'blocks' );

                    this.setState({
                        addingBlock: false,
                        hoveringBlock: false,
                    }, () => {
                        this.onChangeEditingBlock(uid + 1);
                    });
                });
        }
    }

    onRemoveBlock(uid) {
        let htmlMap = this.state.htmlMap;
        htmlMap = htmlMap.replace('<wpupg-replace-shortcode-with-block uid="' + uid + '"></wpupg-replace-shortcode-with-block>', '');

        if ( htmlMap !== this.state.htmlMap) {
            this.setState({
                htmlMap,
            },
                () => {
                    let newHtml = this.unparseHtml();
                    this.props.onChangeHTML(newHtml);
                });
        }
    }

    toggleHover( hovering ) {
        const containers = this.previewItem.current.querySelectorAll('.wpupg-hover');

        for ( let container of containers ) {
            if ( hovering ) {
                container.classList.add('wpupg-hovering');
            } else {
                container.classList.remove('wpupg-hovering');
            }
        }
    }

    render() {
        const parsedHtml = this.state.hasError ? <Loader /> : this.state.parsedHtml;

        let itemClasses = [
            'wpupg-item',
            `wpupg-template-${this.props.template.slug}`,
        ];
        if ( this.state.item && Array.isArray( this.state.item.classes ) ) {
            itemClasses = [
                ...itemClasses,
                ...this.state.item.classes,
            ];
        }

        return (
            <Fragment>
                <div className="wpupg-main-container">
                    <h2 className="wpupg-main-container-name">Preview at <input type="number" min="1" value={ this.state.width } onChange={ (e) => { this.setState({ width: e.target.value } ); } } />px</h2>
                    <div className="wpupg-main-container-preview">
                        <PreviewItem
                            item={ this.state.item }
                            onChange={ (item) => {
                                if ( item !== this.state.item ) {
                                    this.setState( {
                                        item,
                                        html: '', // Force HTML to update.
                                    });
                                }
                            }}
                        />
                        {
                            this.state.item && this.state.item.value
                            ?
                            <Fragment>
                                <style>{ Helpers.parseCSS( this.props.template ) }</style>
                                <div
                                    ref={this.previewItem}
                                    className={ itemClasses.join( ' ' ) }
                                    style={{
                                        width: `${this.state.width}px`,
                                    }}
                                    onMouseEnter={ () => this.toggleHover( true ) }
                                    onMouseLeave={ () => this.toggleHover( false ) }
                                >{ parsedHtml }</div>
                            </Fragment>
                            :
                            <p style={{color: 'darkred', textAlign: 'center'}}>You have to select an item to use for the preview in the dropdown above.<br/>This will be used as an example of one grid item. For a grid of posts, select a post.</p>
                        }
                    </div>
                </div>
                {
                    false === this.state.editingBlock || this.state.shortcodes.length <= this.state.editingBlock
                    ?
                    <BlockProperties>
                        {
                            this.state.shortcodes.map((shortcode, i) => {
                                return (
                                    <div
                                        key={i}
                                        className={ shortcode.uid === this.state.hoveringBlock ? 'wpupg-template-menu-block wpupg-template-menu-block-hover' : 'wpupg-template-menu-block' }
                                        onClick={ () => this.onChangeEditingBlock(shortcode.uid) }
                                        onMouseEnter={ () => this.onChangeHoveringBlock(shortcode.uid) }
                                        onMouseLeave={ () => this.onChangeHoveringBlock(false) }
                                    >{ shortcode.name }</div>
                                );
                            })
                        }
                        {
                             ! this.state.shortcodes.length && <p>There are no adjustable blocks.</p>
                        }
                    </BlockProperties>
                    :
                    null
                }
                <AddBlocks>
                {
                    ! this.state.addingBlock
                    ?
                    <Fragment>
                        <p>Select block to add:</p>
                        <div className="wpupg-template-menu-add-block-group">General Blocks</div>
                        {
                            generalShortcodeKeys.map((id, i) => {
                                return (
                                    <div
                                        key={i}
                                        className="wpupg-template-menu-block"
                                        onClick={ () => this.onChangeAddingBlock(id) }
                                    >{ Helpers.getShortcodeName(id) }</div>
                                );
                            })
                        }
                        <div className="wpupg-template-menu-add-block-group">Grid Item Blocks</div>
                        {
                            gridShortcodeKeys.map((id, i) => {
                                return (
                                    <div
                                        key={i}
                                        className="wpupg-template-menu-block"
                                        onClick={ () => this.onChangeAddingBlock(id) }
                                    >{ Helpers.getShortcodeName(id) }</div>
                                );
                            })
                        }
                        {
                            0 < recipeShortcodeKeys.length
                            &&
                            <Fragment>
                                <div className="wpupg-template-menu-add-block-group">Recipe Blocks</div>
                                {
                                    recipeShortcodeKeys.map((id, i) => {
                                        return (
                                            <div
                                                key={i}
                                                className="wpupg-template-menu-block"
                                                onClick={ () => this.onChangeAddingBlock(id) }
                                            >{ Helpers.getShortcodeName(id) }</div>
                                        );
                                    })
                                }
                            </Fragment>
                        }
                    </Fragment>
                    :
                    <Fragment>
                        <a href="#" onClick={(e) => {
                            e.preventDefault();
                            this.onChangeAddingBlock(false);
                        }}>Cancel</a>
                        <p>Add "{ Helpers.getShortcodeName(this.state.addingBlock) }" after:</p>
                        {
                            this.state.shortcodes.map((shortcode, i) => {
                                return (
                                    <div
                                        key={i}
                                        className={ shortcode.uid === this.state.hoveringBlock ? 'wpupg-template-menu-block wpupg-template-menu-block-hover' : 'wpupg-template-menu-block' }
                                        onClick={ () => this.onAddBlockAfter(shortcode.uid) }
                                        onMouseEnter={ () => this.onChangeHoveringBlock(shortcode.uid) }
                                        onMouseLeave={ () => this.onChangeHoveringBlock(false) }
                                    >{ shortcode.name }</div>
                                );
                            })
                        }
                        {
                            ! this.state.shortcodes.length && <p>There are no blocks in the Template.</p>
                        }
                    </Fragment>
                }
                </AddBlocks>
                <RemoveBlocks>
                {
                    this.state.shortcodes.map((shortcode, i) => {
                        return (
                            <div
                                key={i}
                                className={ shortcode.uid === this.state.hoveringBlock ? 'wpupg-template-menu-block wpupg-template-menu-block-hover' : 'wpupg-template-menu-block' }
                                onClick={ () => {
                                    if (confirm( 'Are you sure you want to delete the "' + shortcode.name + '" block?' )) {
                                        this.onRemoveBlock(shortcode.uid);
                                    }
                                }}
                                onMouseEnter={ () => this.onChangeHoveringBlock(shortcode.uid) }
                                onMouseLeave={ () => this.onChangeHoveringBlock(false) }
                            >{ shortcode.name }</div>
                        );
                    })
                }
                {
                        ! this.state.shortcodes.length && <p>There are no blocks to remove.</p>
                }
                </RemoveBlocks>
            </Fragment>
        );
    }
}
