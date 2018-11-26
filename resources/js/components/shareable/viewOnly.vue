<template>
    <loader v-if="loading"></loader>
    <div v-else 
        class="container-fluid" 
        style="padding-bottom:400px;">
        <div class="row mt-2">
            <div class="col-md-12 pl-1">
                <div class="card card-default">
                    <div class="card-header">
                        Viewing <strong>{{ shareItem.content.title }}</strong>
                    </div>

                    <div id="markdown-viewer-container" class="card-body">
                        <vue-markdown :source="shareItem.content.unparsed_markdown" @rendered="editsUpdated"></vue-markdown>
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

    export default {
        components: {
            VueMarkdown,
            Loader,
        },
        props: {
            shareableId: {
                type: [ String, Number ],
                required: true
            }
        },
        data() {
            return {
                loading: true,
                shareItem: null
            };
        },
        methods: {
            editsUpdated() {
                this.$nextTick( () => {
                    // eslint-disable-next-line no-undef
                    Prism.highlightAll();
                } );
            }
        },
        async mounted() {
            let response = await api.shareable.external( this.shareableId );
            if ( response.success ) {
                this.shareItem = response.data;
            }

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
