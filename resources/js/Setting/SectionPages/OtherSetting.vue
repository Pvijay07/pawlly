<template>
    <form @submit="formSubmit">
      <div>
        <CardTitle title="App Configuration Settings" icon="fa-solid fa-sliders"></CardTitle>
      </div>
     <div class="form-group">
        <div class="d-flex justify-content-between align-items-center">
          <label class="form-label" for="category-enable_event">{{ $t('setting_integration_page.lbl_enable_event') }} </label>
          <div class="form-check form-switch">
            <input class="form-check-input" :true-value="1" :false-value="0" :value="is_event" :checked="is_event == 1 ? true : false" name="is_event" id="category-is_event" type="checkbox" v-model="is_event" />
          </div>
        </div>
      </div>

      <div class="form-group">
        <div class="d-flex justify-content-between align-items-center">
          <label class="form-label" for="category-enable_blog">{{ $t('setting_integration_page.lbl_enable_blog') }} </label>
          <div class="form-check form-switch">
            <input class="form-check-input" :true-value="1" :false-value="0" :value="is_blog" :checked="is_blog == 1 ? true : false" name="is_blog" id="category-is_blog" type="checkbox" v-model="is_blog" />
          </div>
        </div>
      </div>

      <div class="form-group">
        <div class="d-flex justify-content-between align-items-center">
          <label class="form-label" for="category-enable_user_push_notification">{{ $t('setting_integration_page.lbl_enable_user_push_notification') }} </label>
          <div class="form-check form-switch">
            <input class="form-check-input" :true-value="1" :false-value="0" :value="is_user_push_notification" :checked="is_user_push_notification == 1 ? true : false" name="is_user_push_notification" id="category-is_user_push_notification" type="checkbox" v-model="is_user_push_notification" />
          </div>
        </div>
      </div>

      <div class="form-group">
        <div class="d-flex justify-content-between align-items-center">
          <label class="form-label" for="category-enable_provider_push_notification">{{ $t('setting_integration_page.lbl_enable_provider_push_notification') }} </label>
          <div class="form-check form-switch">
            <input class="form-check-input" :true-value="1" :false-value="0" :value="is_provider_push_notification" :checked="is_provider_push_notification == 1 ? true : false" name="is_provider_push_notification" id="category-is_provider_push_notification" type="checkbox" v-model="is_provider_push_notification" />
          </div>
        </div>
      </div>

      <div class="form-group">
        <div class="d-flex justify-content-between align-items-center">
          <label class="form-label" for="category-enable_chat_gpt">{{ $t('setting_integration_page.lbl_enable_chat_gpt') }} </label>
          <div class="form-check form-switch">
            <input class="form-check-input" :true-value="1" :false-value="0" :value="enable_chat_gpt" :checked="enable_chat_gpt == 1 ? true : false" name="enable_chat_gpt" id="category-enable_chat_gpt" type="checkbox" v-model="enable_chat_gpt" />
          </div>
        </div>
      </div>
      <div v-if="enable_chat_gpt == 1">
        <div class="form-group">
          <div class="d-flex justify-content-between align-items-center">
            <label class="form-label" for="category-test_without_key">{{ $t('setting_integration_page.lbl_test_without_key') }} </label>
            <div class="form-check form-switch">
              <input class="form-check-input" :true-value="1" :false-value="0" :value="test_without_key" :checked="test_without_key == 1 ? true : false" name="test_without_key" id="category-test_without_key" type="checkbox" v-model="test_without_key" />
            </div>
          </div>
        </div>
        <div v-if="test_without_key == 0">
          <div class="form-group">
            <label for="category-chatgpt_key">{{ $t('setting_integration_page.key') }}</label>
            <input type="text" class="form-control" v-model="chatgpt_key" id="chatgpt_key" name="chatgpt_key" :errorMessage="errors.chatgpt_key" :errorMessages="errorMessages.chatgpt_key" />
            <p class="text-danger" v-for="msg in errorMessages.chatgpt_key" :key="msg">{{ msg }}</p>
          </div>
        </div>

      
      </div>
    
  
      <SubmitButton :IS_SUBMITED="IS_SUBMITED"></SubmitButton>
    </form>
  </template>
  <script setup>
  import { ref, watch } from 'vue'
  import CardTitle from '@/Setting/Components/CardTitle.vue'
  import * as yup from 'yup'
  import { useField, useForm } from 'vee-validate'
  import { STORE_URL, GET_URL } from '@/vue/constants/setting'
  import { useRequest } from '@/helpers/hooks/useCrudOpration'
  import { onMounted } from 'vue'
  import { createRequest } from '@/helpers/utilities'
  import SubmitButton from './Forms/SubmitButton.vue'
  import InputField from '@/vue/components/form-elements/InputField.vue'
  const { storeRequest } = useRequest()
  const IS_SUBMITED = ref(false)
  //  Reset Form
  const setFormData = (data) => {
    resetForm({
      values: {

        is_event: data.is_event || 0,
        is_blog: data.is_blog || 0,
        is_user_push_notification: data.is_user_push_notification || 0,
        is_provider_push_notification: data.is_provider_push_notification || 0,
        enable_chat_gpt: data.enable_chat_gpt || 0,
        test_without_key: data.test_without_key || 0,
        chatgpt_key: data.chatgpt_key || '',
       
      }
    })
  }
  //validation
  const validationSchema = yup.object({
    chatgpt_key: yup.string().test('chatgpt_key', 'Must be a valid ChatGPT key', function (value) {
      if (this.parent.test_without_key == '0' && !value) {
        return false;
      }
      return true
    }),
  })
  const { handleSubmit, errors, resetForm, validate } = useForm({validationSchema})
  const errorMessages = ref({})
  const { value: is_event } = useField('is_event')
  const { value: is_blog } = useField('is_blog')
  const { value: is_user_push_notification } = useField('is_user_push_notification')
  const { value: is_provider_push_notification } = useField('is_provider_push_notification')
  const { value: enable_chat_gpt } = useField('enable_chat_gpt')
  const { value: test_without_key } = useField('test_without_key')
  const { value: chatgpt_key } = useField('chatgpt_key')
  

  watch(() => test_without_key.value, (value) => {
    if(value == '1') {
      chatgpt_key.value = ''
    }
  }, {deep: true})
  


  // message
  const display_submit_message = (res) => {
    IS_SUBMITED.value = false
    if (res.status) {
      window.successSnackbar(res.message)
    } else {
      window.errorSnackbar(res.message)
      errorMessages.value = res.errors
    }
  }
  
  //fetch data
  const data = [
    'is_event',
    'is_blog',
    'is_user_push_notification',
    'is_provider_push_notification',
    'enable_chat_gpt',
    'test_without_key',
    'chatgpt_key',
   
  ]
  
 
  onMounted(() => {
  
    const customData = [
      ...data,

    ].join(",")
  
    createRequest(GET_URL(customData)).then((response) => {
      setFormData(response)
    })
  })
  
  //Form Submit
  const formSubmit = handleSubmit((values) => {
    IS_SUBMITED.value = true
    const newValues = {}
    Object.keys(values).forEach((key) => {
      if(values[key] !== '') {
        newValues[key] = values[key] || ''
      }

      console.log(newValues)
    })
    storeRequest({
      url: STORE_URL, 
      body: newValues
    }).then((res) => display_submit_message(res))
  })
  
  defineProps({
    label: { type: String, default: '' },
    modelValue: { type: String, default: '' },
    placeholder: { type: String, default: '' },
    errorMessage: { type: String, default: '' },
    errorMessages: { type: Array, default: () => [] }
  })
  </script>
  