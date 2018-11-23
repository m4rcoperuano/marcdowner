<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <h4 class="mt-1">
          <strong>Document Title</strong>
        </h4>
      </div>
      <div class="col-md-6">
        <div class="text-right">
          <button class="btn btn-info text-light">
            Share
          </button>
          <button class="btn btn-success" @click="save">
            Save
          </button>
        </div>
      </div>
    </div>
    <div class="row mt-2">
      <div class="col-md-6 pr-1">
        <div class="card card-default">
          <div class="card-header">
            Editor
          </div>

          <div class="card-body" id="markdown-textarea-container">
            <textarea-autosize placeholder="Markdown..." autofocus class="form-control" id="markdown-textarea" v-model="markdown">
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
            <vue-markdown @rendered="editsUpdated" :source="markdown"></vue-markdown>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    import VueMarkdown from "vue-markdown";
    import api from '../../api';

    export default {
        components: {
            VueMarkdown
        },
        data() {
            return {
                markdown: ''
            }
        },
        methods: {
            editsUpdated() {
                this.$nextTick(() => {
                    Prism.highlightAll();
                });
            },
            save() {
                api.saveEdits({
                    content: this.markdown
                });
            }
        }
    }
</script>

<style scoped>
  #markdown-viewer-container {
    padding-bottom: 40px;
    min-height: 99px;
  }

  #markdown-textarea {
    border-radius:0;
    border:0;
    min-height:99px;
  }

  #markdown-textarea-container {
    overflow: hidden;
    padding:0;
  }
</style>
