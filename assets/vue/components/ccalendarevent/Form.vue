<template>
  <q-form>
    <q-input
        id="item_title"
        v-model="item.title"
        :placeholder="$t('Title')"
        :error="v$.item.title.$error"
        @input="v$.item.title.$touch()"
        @blur="v$.item.title.$touch()"
        :error-message="titleErrors"
    />

    <q-input filled v-model="item.startDate">
      <template v-slot:prepend>
        <q-icon name="event" class="cursor-pointer">
          <q-popup-proxy transition-show="scale" transition-hide="scale">
            <q-date v-model="item.startDate" mask="YYYY-MM-DD HH:mm">
              <div class="row items-center justify-end">
                <q-btn v-close-popup label="Close" color="primary" flat />
              </div>
            </q-date>
          </q-popup-proxy>
        </q-icon>
      </template>

      <template v-slot:append>
        <q-icon name="access_time" class="cursor-pointer">
          <q-popup-proxy transition-show="scale" transition-hide="scale">
            <q-time v-model="item.startDate" mask="YYYY-MM-DD HH:mm" format24h>
              <div class="row items-center justify-end">
                <q-btn v-close-popup label="Close" color="primary" flat />
              </div>
            </q-time>
          </q-popup-proxy>
        </q-icon>
      </template>
    </q-input>

    <q-input filled v-model="item.endDate">
      <template v-slot:prepend>
        <q-icon name="event" class="cursor-pointer">
          <q-popup-proxy transition-show="scale" transition-hide="scale">
            <q-date v-model="item.endDate" mask="YYYY-MM-DD HH:mm">
              <div class="row items-center justify-end">
                <q-btn v-close-popup label="Close" color="primary" flat />
              </div>
            </q-date>
          </q-popup-proxy>
        </q-icon>
      </template>

      <template v-slot:append>
        <q-icon name="access_time" class="cursor-pointer">
          <q-popup-proxy transition-show="scale" transition-hide="scale">
            <q-time v-model="item.endDate" mask="YYYY-MM-DD HH:mm" format24h>
              <div class="row items-center justify-end">
                <q-btn v-close-popup label="Close" color="primary" flat />
              </div>
            </q-time>
          </q-popup-proxy>
        </q-icon>
      </template>
    </q-input>

    <VueMultiselect
        placeholder="To"
        v-model="item.receivers"
        :loading="isLoadingSelect"
        :options="users"
        :multiple="true"
        :searchable="true"
        :internal-search="false"
        @search-change="asyncFind"
        limit-text="3"
        limit="3"
        label="username"
        track-by="id"
        :allow-empty="false"
        @input="v$.item.receivers.$touch()"
    />

<!--    <q-checkbox label="Collective" v-model="item.collective"></q-checkbox>-->

    <q-input
        v-model="item.content"
        type="textarea"
        :placeholder="$t('Content')"
        :error="v$.item.content.$error"
        @input="v$.item.content.$touch()"
        @blur="v$.item.content.$touch()"
        :error-message="contentErrors"
    />

    <slot></slot>
  </q-form>
</template>

<script>
import has from 'lodash/has';
import useVuelidate from '@vuelidate/core';
import { required } from '@vuelidate/validators';
import VueMultiselect from 'vue-multiselect'
import {ref} from "vue";
import axios from "axios";
import {ENTRYPOINT} from "../../config/entrypoint";

export default {
  name: 'CCalendarEventForm',
  components: {
    VueMultiselect
  },
  setup () {
    const users = ref([]);
    const isLoadingSelect = ref(false);

    function asyncFind (query) {
      if (query.toString().length < 3) {
        return;
      }

      isLoadingSelect.value = true;
      axios.get(ENTRYPOINT + 'users', {
        params: {
          username: query
        }
      }).then(response => {
        isLoadingSelect.value = false;
        let data = response.data;
        users.value = data['hydra:member'];
      }).catch(function (error) {
        isLoadingSelect.value = false;
      });
    }

    return { v$: useVuelidate(), users, asyncFind, isLoadingSelect }
  },
  props: {
    values: {
      type: Object,
      required: true
    },
    errors: {
      type: Object,
      default: () => {}
    },
    initialValues: {
      type: Object,
      default: () => {}
    },
  },
  data() {
    return {
      title: null,
      content: null,
      parentResourceNodeId: null,
    };
  },
  computed: {
    item() {
      return this.initialValues || this.values;
    },
    titleErrors() {
      const errors = [];
      if (!this.v$.item.title.$dirty) return errors;
      has(this.violations, 'title') && errors.push(this.violations.title);

      if (this.v$.item.title.required) {
        return this.$t('Field is required')
      }

      return errors;
    },

    violations() {
      return this.errors || {};
    }
  },
  validations: {
    item: {
      title: {
        required,
      },
      content: {
        required,
      },
      startDate: {
        required,
      },
      endDate: {
        required,
      },
    }
  }
};
</script>
