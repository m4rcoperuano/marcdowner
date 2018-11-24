<template>
  <loader v-if="loading"></loader>
  <div v-else class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <input type="text"
               v-model="contentItem.title"
               id="content-title"
               v-on:keyup.13="save"
               class="form-control d-inline-block w-75"/>
        <span class="fa fa-edit" id="content-title-pencil"></span>
      </div>
      <div class="col-md-6">
        <div class="text-right">
          <transition name="fade">
            <strong class="text-success d-inline-block mr-2">
              {{ activityMessage }}
            </strong>
          </transition>
          <strong v-if="shareItem && !activityMessage" class="text-info d-inline-block mr-2">
            {{ shareItem.shareable_url }}
            <span v-clipboard:copy="shareItem.shareable_url"
                  v-clipboard:success="showClipboardSuccess"
                  v-clipboard:error="showClipboardSuccess"
                  class="fa fa-copy"
                  id="share-link-copy-button">
            </span>
          </strong>
          <button v-if="!shareItem" class="btn btn-info text-light" @click="share" :disabled="activityMessage">
            Share
          </button>
          <button v-else-if="!activityMessage" class="btn btn-danger text-light" @click="deleteShare">
            Delete Share
          </button>
          <button v-shortkey="['ctrl', 's']" class="btn btn-success" @click="save" @shortkey="save">
            Save
          </button>
        </div>
      </div>
    </div>
    <div class="row mt-2">
      <div class="col-md-6 pr-1">
        <div class="card card-default">
          <div class="card-header text-light bg-dark">
            Editor
          </div>

          <div class="card-body" id="markdown-textarea-container">
            <textarea-autosize placeholder="Markdown..." autofocus class="form-control" id="markdown-textarea"
                               v-model="contentItem.unparsed_markdown">
            </textarea-autosize>
          </div>
        </div>
      </div>
      <div class="col-md-6 pl-1">
        <div class="card card-default">
          <div class="card-header">
            Viewer
          </div>

          <div class="card-body" id="markdown-viewer-container">
            <vue-markdown @rendered="editsUpdated" :source="contentItem.unparsed_markdown"></vue-markdown>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    import VueMarkdown from "vue-markdown";
    import api from '../../api';
    import Loader from '../utils/loader'

    export default {
        components: {
            VueMarkdown,
            Loader
        },
        props: {
            contentId: {
                type: [String, Number],
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
                savedExecutedQueue: 0
            }
        },
        computed: {
            shouldSave() {
                return this.savedTitle.trim() !== this.contentItem.title.trim() ||
                    this.savedContent.trim() !== this.contentItem.unparsed_markdown.trim();
            }
        },
        methods: {
            editsUpdated() {
                this.$nextTick(() => {
                    Prism.highlightAll();
                });
            },
            async save() {
                if (!this.shouldSave)
                    return;

                this.activityMessage = 'Saving......';
                this.savedExecutedQueue += 1;

                let response = await api.content.update(this.contentId, {
                    content: this.contentItem.unparsed_markdown,
                    title: this.contentItem.title
                });

                if (response.success) {
                    this.savedTitle = response.data.title;
                    this.savedContent = response.data.unparsed_markdown;

                    this.savedExecutedQueue -= 1;

                    if (this.savedExecutedQueue <= 0) {
                        this.activityMessage = null;
                    }
                }
            },
            async share() {
                await this.save();
                this.activityMessage = 'Generating link...';

                let response = await api.shareable.create({
                    contentId: this.contentItem.id
                });

                if (response.success) {
                    this.shareItem = response.data;
                }

                this.activityMessage = null;
            },
            showClipboardSuccess(isSuccess) {
                if (isSuccess) {
                    alert('Copied!');
                }
                else {
                    alert('Could not copy to your clipboard :(');
                }
            },
            async deleteShare() {
                this.activityMessage = "Removing...";
                let response = await api.shareable.delete(this.shareItem.id);
                if (response.success) {
                    this.shareItem = null;
                }

                this.activityMessage = null;
            }
        },
        async mounted() {
            this.activityMessage = 'Loading...';
            let contentResponse = await api.content.get(this.contentId);
            if (contentResponse.success) {
                this.contentItem = Object.assign(contentResponse.data, {});
                this.savedTitle = this.contentItem.title;
                this.savedContent = this.contentItem.unparsed_markdown;
            }

            let response = await api.shareable.get(this.contentId);
            if (response.success) {
                this.shareItem = response.data;
            }

            this.activityMessage = null;
            this.loading = false;
        }
    }
</script>

<style scoped>
  #content-title {
    background: none;
    border: 0;
    font-weight: bold;
    font-size: 25px;
  }

  #content-title:hover {
    background-color: white;
  }

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

  #content-title-pencil {
    display: inline-block;
    margin-left: -30px;
    font-size: 19px;
  }

  #share-link-copy-button {
    cursor:pointer;
  }
</style>
