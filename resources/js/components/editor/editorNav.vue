<template xmlns:v-clipboard="http://www.w3.org/1999/xhtml">
    <div class="row">
        <div class="col-12 col-md-6">
            <input id="content-title"
                v-model="contentItem.title"
                type="text"
                class="form-control pl-1"
                tabindex="0"
                @keyup.13="$emit('save')"/>
        </div>
        <div class="col-12 col-md-6">
            <div class="text-right">
                <strong v-if="activityMessage" class="text-success d-inline-block mr-2">
                    {{ activityMessage }}
                </strong>
                <strong v-if="shareItem && !activityMessage" class="text-info d-inline-block mr-2">
                    {{ shareItem.shareable_url }}
                    <span v-clipboard:copy="shareItem.shareable_url"
                        v-clipboard:success="showClipboardSuccess"
                        v-clipboard:error="showClipboardSuccess"
                        id="share-link-copy-button"
                        class="fa fa-copy">
                    </span>
                </strong>
                <button v-if="!shareItem"
                    :disabled="activityMessage"
                    class="btn btn-info text-light"
                    tabindex="-1"
                    @click="$emit('share')">
                    Share
                </button>
                <button v-else-if="!activityMessage"
                    class="btn btn-danger text-light"
                    tabindex="-1"
                    @click="$emit('deleteShare')">
                    Delete Share
                </button>
                <button v-shortkey="['ctrl', 's']"
                    class="btn btn-success"
                    tabindex="-1"
                    title="[CTRL + S]"
                    @click="$emit('save')"
                    @shortkey="$emit('save')">
                    <span v-if="!shouldSave">
                        Saved
                        <span class="fas fa-check-circle"></span>
                    </span>
                    <span v-else>
                        Save?
                    </span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            contentItem: {
                type: Object,
                default: null
            },
            shareItem: {
                type: Object,
                default: null
            },
            activityMessage: {
                type: String,
                default: null
            },
            shouldSave: {
                type: Boolean,
                default: false
            }
        },
        methods: {
            showClipboardSuccess( isSuccess ) {
                if ( isSuccess ) {
                    alert( 'Copied!' );
                }
                else {
                    alert( 'Could not copy to your clipboard :(' );
                }
            },
        }
    };
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

    #share-link-copy-button {
        cursor:pointer;
    }
</style>