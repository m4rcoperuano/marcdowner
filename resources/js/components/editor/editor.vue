<template>
    <loader v-if="loading"></loader>
    <div v-else 
        class="container-fluid p-0 pl-md-3 pr-md-3"
        style="padding-bottom:400px;">
        <editor-nav :content-item="contentItem"
            :share-item="shareItem"
            :activity-message="activityMessage"
            :should-save="shouldSave"
            @save="save"
            @share="share"
            @deleteShare="deleteShare">
        </editor-nav>
        <div class="row mt-2">
            <div class="col-md-6 pr-md-1 col-12 mb-3">
                <div class="card card-default">
                    <div class="card-header text-light bg-dark">
                        Editor
                    </div>

                    <div id="markdown-textarea-container" class="card-body">
                        <textarea id="markdown-textarea"
                            ref="markdownTextarea"
                            :style="`height:${autoSizeTextAreaHeight}px;overflow:hidden;`"
                            v-model="contentItem.unparsed_markdown"
                            rows="1" 
                            placeholder="Markdown..." 
                            class="form-control"
                            @keyup="autoSizeTextarea">
                        </textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-6 pl-md-1 col-12">
                <div class="card card-default">
                    <div class="card-header">
                        Viewer
                    </div>

                    <div id="markdown-viewer-container" class="card-body">
                        <vue-markdown :source="contentItem.unparsed_markdown" @rendered="editsUpdated"></vue-markdown>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VueMarkdown from 'vue-markdown';
    import api from '../../api';
    import Loader from '../utils/loader';
    import EditorNav from './editorNav';

    export default {
        components: {
            VueMarkdown,
            Loader,
            EditorNav
        },
        props: {
            contentId: {
                type: [ String, Number ],
                required: true
            }
        },
        data() {
            return {
                contentItem: {},
                savedTitle: '',
                savedContent: '',
                activityMessage: null,
                loading: true,
                shareItem: null,
                savedExecutedQueue: 0,
                autoSizeTextAreaHeight: 100
            };
        },
        computed: {
            shouldSave() {
                if ( !this.contentItem || !this.savedTitle || !this.savedContent ) return true;

                return this.savedTitle.trim() !== this.contentItem.title.trim() ||
                    this.savedContent.trim() !== this.contentItem.unparsed_markdown.trim();
            }
        },
        watch: {
            'shouldSave': function( value ) {
                window.onbeforeunload = value ? function(){
                    return 'Are you sure you want to leave?';
                } : null;
            }
        },
        methods: {
            editsUpdated() {
                this.$nextTick( () => {
                    Prism.highlightAll();
                } );
            },
            async save() {
                if ( !this.shouldSave )
                    return;

                this.activityMessage = 'Saving......';
                this.savedExecutedQueue += 1;

                let response = await api.content.update( this.contentId, {
                    content: this.contentItem.unparsed_markdown,
                    title: this.contentItem.title
                } );

                if ( response.success ) {
                    this.savedTitle = response.data.title;
                    this.savedContent = response.data.unparsed_markdown;

                    this.savedExecutedQueue -= 1;

                    if ( this.savedExecutedQueue <= 0 ) {
                        this.activityMessage = null;
                    }
                }
            },
            async share() {
                await this.save();
                this.activityMessage = 'Generating link...';

                let response = await api.shareable.create( {
                    contentId: this.contentItem.id
                } );

                if ( response.success ) {
                    this.shareItem = response.data;
                }

                this.activityMessage = null;
            },
            async deleteShare() {
                this.activityMessage = 'Removing...';
                let response = await api.shareable.delete( this.shareItem.id );
                if ( response.success ) {
                    this.shareItem = null;
                }

                this.activityMessage = null;
            },
            autoSizeTextarea() {
                this.autoSizeTextAreaHeight = this.$refs.markdownTextarea.scrollHeight;
            }
        },
        async mounted() {
            this.activityMessage = 'Loading...';
            let contentResponse = await api.content.get( this.contentId );
            if ( contentResponse.success ) {
                this.contentItem = Object.assign( contentResponse.data, {} );
                this.savedTitle = this.contentItem.title;
                this.savedContent = this.contentItem.unparsed_markdown;
            }

            let response = await api.shareable.get( this.contentId );
            if ( response.success ) {
                this.shareItem = response.data;
            }

            setTimeout( () => {
                this.autoSizeTextarea();
            }, 0 );

            this.activityMessage = null;
            this.loading = false;
        },
    };
</script>

<style scoped>
  #markdown-viewer-container {
    padding-bottom: 40px;
    min-height: 99px;
  }

  #markdown-textarea {
    border-radius: 0;
    border: 0;
    min-height: 99px;
  }

  #markdown-textarea-container {
    overflow: hidden;
    padding: 0;
  }
</style>
