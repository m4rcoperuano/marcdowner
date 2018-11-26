<template>
    <small-loader v-if="loading"></small-loader>
    <div v-else>
        <ul>
            <li v-for="content in contentItems" :key="content.id">
                <a :href="`/editor/${content.id}`">
                    {{ content.title }} - Last modified {{ formatCreatedAt(content.created_at) }}
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
    import api from '../../api';
    import SmallLoader from '../utils/smallLoader';
    import moment from 'moment';

    export default {
        components: {
            SmallLoader
        },
        data() {
            return {
                contentItems : [],
                loading : true
            };
        },
        methods: {
            formatCreatedAt( date ) {
                return moment().utc( date ).calendar().toLowerCase();
            }
        },
        async mounted() {
            let response = await api.content.all();
            if ( response.success ) {
                this.contentItems = response.data;
            }

            this.loading = false;
        }
    };
</script>

<style scoped>
  ul {
    list-style-type: none;
    padding:0;
    margin:0;
  }
  ul li {
    display:block;
    padding:0;
    margin:0;
  }
  ul li  a  {
    display:block;
    padding:5px;
    text-decoration: none;
  }
  ul li  a:hover {
    background-color:white;
  }
</style>