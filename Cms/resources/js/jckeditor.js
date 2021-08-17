// Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to find stuff you want to use
// Scroll down to the 'installation' Table of Content entry for that feature. Expect something like this.
// npm install --save @ckeditor/ckeditor5-heading
// add 'import Heading1 from '@ckeditor/ckeditor5-heading/src/heading';' to this file
// add Heading1 to the ClassicEditor.creat.plugins
// add heading as a keyword in the 'toolbar', as appropriate
//import Heading from '@ckeditor/ckeditor5-heading/src/heading';
//import Code from '@ckeditor/ckeditor5-basic-styles/src/code';
//import Subscript from '@ckeditor/ckeditor5-basic-styles/src/subscript';
//import Superscript from '@ckeditor/ckeditor5-basic-styles/src/superscript';

import ClassicEditor from '@ckeditor/ckeditor5-editor-classic/src/classiceditor';
import Essentials from '@ckeditor/ckeditor5-essentials/src/essentials';
import Paragraph from '@ckeditor/ckeditor5-paragraph/src/paragraph';
import Bold from '@ckeditor/ckeditor5-basic-styles/src/bold';
import Italic from '@ckeditor/ckeditor5-basic-styles/src/italic';
import Underline from '@ckeditor/ckeditor5-basic-styles/src/underline';
import Strikethrough from '@ckeditor/ckeditor5-basic-styles/src/strikethrough';
import Highlight from '@ckeditor/ckeditor5-highlight/src/highlight';
import HorizontalLine from '@ckeditor/ckeditor5-horizontal-line/src/horizontalline';
import RemoveFormat from '@ckeditor/ckeditor5-remove-format/src/removeformat';
import FontSize from '@ckeditor/ckeditor5-font/src/font';
import FontColor from '@ckeditor/ckeditor5-font/src/font';
import EasyImage from '@ckeditor/ckeditor5-easy-image/src/easyimage';
import Image from '@ckeditor/ckeditor5-image/src/image';
import ImageToolbar from '@ckeditor/ckeditor5-image/src/imagetoolbar';
import ImageCaption from '@ckeditor/ckeditor5-image/src/imagecaption';
import ImageStyle from '@ckeditor/ckeditor5-image/src/imagestyle';
import ImageResize from '@ckeditor/ckeditor5-image/src/imageresize';
import LinkImage from '@ckeditor/ckeditor5-link/src/linkimage';
import ImageInsert from "@ckeditor/ckeditor5-image/src/imageinsert";
import CloudServices from "@ckeditor/ckeditor5-cloud-services/src/cloudservices"; // Needed (but not obvious) by EasyImage
import MediaEmbed from '@ckeditor/ckeditor5-media-embed/src/mediaembed';
import Alignment from '@ckeditor/ckeditor5-alignment/src/alignment';
import Table from '@ckeditor/ckeditor5-table/src/table';
import TableToolbar from '@ckeditor/ckeditor5-table/src/tabletoolbar';
import TableProperties from '@ckeditor/ckeditor5-table/src/tableproperties';
import TableCellProperties from '@ckeditor/ckeditor5-table/src/tablecellproperties';
import Indent from '@ckeditor/ckeditor5-indent/src/indent';
import IndentBlock from '@ckeditor/ckeditor5-indent/src/indentblock';
//import IndentBlock from '@ckeditor/ckeditor5-indent/src/listui';
//import ListUi from '@ckeditor/ckeditor5-list/src/liststyle';
//import ListUi from '@ckeditor/ckeditor5-list/src/listui' // enabled by default https://ckeditor.com/docs/ckeditor5/latest/features/lists/lists.html
import ListUi from '@ckeditor/ckeditor5-list/src/list';

// This works
// ClassicEditor
//     .create( document.querySelector( '#editor' ), {
//         plugins: [ Essentials, Paragraph, Bold, Italic ],
//         toolbar: [ 'bold', 'italic' ]
//     } )
//     .then( editor => {
//         console.log( 'Editor was initialized', editor );
//     } )
//     .catch( error => {
//         console.error( error.stack );
//     } );

// This works
// ClassicEditor
//     .create( document.querySelector( '#editor' ), {
//         plugins: [ Essentials, Paragraph, Bold, Italic ],
//         toolbar: [ 'bold', 'italic' ],
//         cloudServices: {
//             tokenUrl: 'https://80987.cke-cs.com/token/dev/822603d3b3ed1ec825a11053e9e3ca93461cb214bd2c98783b1a250422b3',
//             uploadUrl: 'https://80987.cke-cs.com/easyimage/upload/'
//         }
//     })
//
//     .catch( error => {
//         console.error( error );
//     } );

function jAttachEditor(selector, onCreateWith_theEditor_Var, $refAlpineDispatch) {
    const imageConfiguration = {
        // Configure the available styles.
        styles: [
            'alignLeft', 'alignCenter', 'alignRight'
        ],
        resizeOptions: [
            {
                name: 'resizeImage:original',
                value: null,
                icon: 'original'
            },
            {
                name: 'resizeImage:50',
                value: '50',
                icon: 'medium'
            },
            {
                name: 'resizeImage:75',
                value: '75',
                icon: 'large'
            }
        ],
        // You need to configure the image toolbar, too, so it shows the new style
        // buttons as well as the resize buttons.
        toolbar: [
            'imageStyle:alignLeft', 'imageStyle:alignCenter', 'imageStyle:alignRight',
            '|',
            'resizeImage:50',
            'resizeImage:75',
            'resizeImage:original',
            '|',
            'imageTextAlternative'
        ]

    };

    let geditor;// global references to the ckeditor https://ckeditor.com/docs/ckeditor5/latest/builds/guides/integration/saving-data.html#autosave-feature
    ClassicEditor
        .create(document.querySelector(selector), {
            plugins: [
                Essentials,
                Paragraph,
                Bold, Italic, Underline, Strikethrough,//https://ckeditor.com/docs/ckeditor5/latest/features/basic-styles.html#installation
                //Code, Subscript, Superscript
                Indent, IndentBlock, //https://ckeditor.com/docs/ckeditor5/latest/features/indent.html#installation

                //Heading,// https://ckeditor.com/docs/ckeditor5/latest/features/headings.html
                Highlight,//https://ckeditor.com/docs/ckeditor5/latest/features/highlight.html#demo
                HorizontalLine,//https://ckeditor.com/docs/ckeditor5/latest/features/horizontal-line.html
                RemoveFormat, //https://ckeditor.com/docs/ckeditor5/latest/features/remove-format.html#installation
                FontSize, //https://ckeditor.com/docs/ckeditor5/latest/features/font.html#installation
                FontColor, // "
                Image,
                ImageInsert,
                CloudServices, // Needed by EasyImage https://ckeditor.com/docs/ckeditor5/latest/api/cloud-services.html

                ImageToolbar, ImageCaption, ImageStyle, ImageResize, LinkImage,
                EasyImage, //https://ckeditor.com/docs/ckeditor5/latest/features/image-upload/easy-image.html#installation
                MediaEmbed, //https://ckeditor.com/docs/ckeditor5/latest/features/media-embed.html#automatic-media-embed-on-paste
                Alignment, //https://ckeditor.com/docs/ckeditor5/latest/features/text-alignment.html#installation
                Table, TableToolbar, TableProperties, TableCellProperties, //https://ckeditor.com/docs/ckeditor5/latest/features/table.html

                // Fancy formatting - which we hate, so just use the built-in: ListStyle,//https://ckeditor.com/docs/ckeditor5/latest/features/lists/lists.html#common-api
                ListUi, //built-in

            ],


            toolbar: { //https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html
                shouldNotGroupWhenFull: true,
                items:

                    [
                        //'heading',
                        'fontSize', '|',
                        'bold', 'italic', 'underline', 'strikethrough', '|',
                        'fontColor', 'highlight:yellowMarker', 'highlight:pinkMarker', 'highlight:greenMarker', '|',
                        //'fontBackgroundColor',
                        'removeFormat',

                        '-',
                        //'alignment',
                        'alignment:left', 'alignment:right', 'alignment:center', 'alignment:justify', '|',
                        'horizontalLine', '|',
                        'outdent', 'indent', '|',
                        'bulletedList', 'numberedList',

                        '-',
                        'link', 'uploadImage', /* 'mediaEmbed', doesn't display, fix later. Links can be pasted in, but don't display */ '|',
                        //'insertImage'

                        // 'linkImage',
                        'insertTable', '|',

                        'undo',
                        'redo'

                    ],

            },
            // heading: {
            //     options: [
            //         { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
            //         { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
            //         { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' }
            //     ]
            // },
            language: 'en',
            image: imageConfiguration,
            table: {
                contentToolbar: [
                    'tableColumn',
                    'tableRow',
                    'mergeTableCells',
                    'tableCellProperties',
                    'tableProperties'
                ]
            },
            cloudServices: {
                tokenUrl: 'https://80987.cke-cs.com/token/dev/fd081f129e1041bf16f94c370e22cbdc14e1ae4e71a225ea23787fe06adb',
                uploadUrl: 'https://80987.cke-cs.com/easyimage/upload/'
            },


        })
        .then(editor => {
            window.geditor = editor;
            // This works...
            // editor.model.document.on( 'change:data', () => { // https://github.com/ckeditor/ckeditor5/issues/996#issuecomment-571944011
            //     console.log('The data has changed!');
            // });

            // This works...
            // window.editor.model.document.on('change:data', () => { // https://github.com/ckeditor/ckeditor5/issues/996#issuecomment-571944011
            //     console.log('The data has changed! (written fromwithin jckeditor.js)');
            // });
            onCreateWith_theEditor_Var(editor, $refAlpineDispatch);

            // editor.model.document.on( 'change:data', () => { // https://github.com/ckeditor/ckeditor5/issues/996#issuecomment-571944011
            //     console.log( 'The data has changed!' );
            //     // Dispatch to alpine so it can act on this information: https://www.sitepoint.com/javascript-custom-events/
            //     var event = new CustomEvent(
            //         "newMessage",
            //         {
            //             detail: {
            //                 message: "Hello World!",
            //                 time: new Date(),
            //             },
            //             bubbles: true,
            //             cancelable: true
            //         }
            //     );
            //     document.dispatchEvent(event);
            //
            // } );
        })

        .catch(handleError);

    function handleError(error) {
        console.error('Oops, something went wrong! Look at the stack trace here in the console.');
        // console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
        // console.warn( 'Build id: JJ custom build.' );
        console.error(error);
    }

//document.addEventListener("newMessage", e => {console.log('Hello from newMessage')}, false);
}
window.jEditorAttached = jAttachEditor;
//--------------- Ckeditor WIP -----------------------
