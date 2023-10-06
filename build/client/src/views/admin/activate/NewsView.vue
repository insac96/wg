<template lang="pug">
  div(class="ActivateNewsView")
    UTableAdmin(
      :head="head"
      :reload="reload"
      :select.sync="select"
      get-action="getAllNews"
      first-sort="update_time"
      action-create
      action-one
      action-two
      @create="createNews"
      @one="updateNews"
      @two="deleteNews"
    )
      template(#create)
        UInput(v-model="addVal.title" label-top="Tiêu đề")
        UInput(v-model="addVal.description" label-top="Mô tả")
        UInput(v-model="addVal.img" label-top="Link Ảnh nếu có")
        USelect(v-model="addVal.type" :list="typeVal" label-top="Loại tin tức")
        USelect(v-model="addVal.display" :list="displayVal" label-top="Hiển thị")
        quill-editor(:content="addVal.content" :options="editorOption" @change="onEditorChangeCreate($event)")

      template(#one v-if="select")
        UInput(v-model="select.title" label-top="Tiêu đề")
        UInput(v-model="select.description" label-top="Mô tả")
        UInput(v-model="select.img" label-top="Link Ảnh nếu có")
        USelect(v-model="select.type" :list="typeVal" label-top="Loại tin tức")
        USelect(v-model="select.display" :list="displayVal" label-top="Hiển thị")
        quill-editor(:content="select.content" :options="editorOption" @change="onEditorChangeEdit($event)")

      template(#two v-if="select")
        UAlert(color="danger" border) Bạn chắc chắn muốn xóa tin tức [{{select.title}}] khỏi danh sách ?
        
</template>

<script>
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import { quillEditor } from 'vue-quill-editor'

export default {
  components: {
    quillEditor
  },

  data() {
    return {
      head: {
        'id': 'ID',
        'title': 'Tiêu đề',
        'type': 'Loại',
        'viewer': 'Lượt xem',
        'display': 'Hiển thị',
        'update_time': 'Cập nhật'
      },

      select: null,

      reload: 0,

      addVal: {
        title: null,
        description: null,
        content: null,
        type: null,
        img: null,
        title_seo: null,
        display: 1
      },

      displayVal: [
        { value: 0, label: 'Ẩn' },
        { value: 1, label: 'Hiện' },
      ],

      typeVal: [
        { value: 'new', label: 'New' },
        { value: 'hot', label: 'Hot' },
        { value: 'update', label: 'Update' },
      ],

      editorOption: {
        theme: 'snow'
      }
    }
  },

  methods: {
    async createNews () {
      this.addVal.title_seo = this.makeTitleSeo(this.addVal.title)
      const create = await this.API('createNews', this.addVal, true)
      if(!!create) return this.onReload()
    },

    async updateNews () {
      this.select.title_seo  = this.makeTitleSeo(this.select.title)
      const update = await this.API('updateNews', this.select, true)
      if(!!update) return this.onReload()
    },

    async deleteNews () {
      const del = await this.API('deleteNews', {
        news_id: this.select.id
      }, true)
      if(!!del) return this.onReload()
    },

    onEditorChangeCreate({ quill, html, text }) {
      this.addVal.content = html
    },

    onEditorChangeEdit({ quill, html, text }) {
      this.select.content = html
    },

    makeTitleSeo (title) {
      let str = title
      str = str.toLowerCase();
      str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a"); 
      str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e"); 
      str = str.replace(/ì|í|ị|ỉ|ĩ/g,"i"); 
      str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o"); 
      str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u"); 
      str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y"); 
      str = str.replace(/đ/g,"d");
      str = str.replace(/À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/g, "A");
      str = str.replace(/È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/g, "E");
      str = str.replace(/Ì|Í|Ị|Ỉ|Ĩ/g, "I");
      str = str.replace(/Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/g, "O");
      str = str.replace(/Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/g, "U");
      str = str.replace(/Ỳ|Ý|Ỵ|Ỷ|Ỹ/g, "Y");
      str = str.replace(/Đ/g, "D");
      str = str.replace(/\u0300|\u0301|\u0303|\u0309|\u0323/g, "");
      str = str.replace(/\u02C6|\u0306|\u031B/g, "");
      str = str.replace(/ + /g,"-");
      str = str.replace(/ /g,"-");
      str = str.replace(/[/]/g,"-");
      str = str.trim();
      return str;
    },

    onReload () {
      this.reload = this.reload + 1
      this.addVal = {
        title: null,
        description: null,
        content: null,
        type: null,
        img: null,
        title_seo: null,
        display: 1
      }
    }
  },
}
</script>