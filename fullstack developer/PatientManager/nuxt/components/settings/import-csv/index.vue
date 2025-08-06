<template>
  <div class="import-csv-container container">
    <div class="import-csv-header">
      <h2>Import CSV File</h2>
      <p>Upload a CSV file to import patient data into the system.</p>
    </div>

    <div class="import-csv-content">
      <FileUpload
        ref="fileUploadRef"
        name="file"
        :url="uploadUrl"
        :multiple="false"
        accept=".csv,text/csv"
        :maxFileSize="10000000"
        :auto="false"
        chooseLabel="Choose CSV File"
        uploadLabel="Upload"
        cancelLabel="Cancel"
        @upload="onUpload"
        @error="onError"
        class="csv-uploader"
        :customUpload="true"
        @uploader="customUploader"
      >
        <template #empty>
          <div class="upload-empty-state">
            <i class="pi pi-cloud-upload upload-icon"></i>
            <p>Drag and drop a CSV file here to upload, or click to browse.</p>
            <small>Maximum file size: 10MB</small>
          </div>
        </template>
      </FileUpload>
    </div>
    <Toast />
  </div>
</template>

<script setup lang="ts">
const config = useRuntimeConfig()
const fileUploadRef = ref()
const uploadUrl = ref(config.public.apiUrl + '/import/csv')
const toast = useToast()

async function customUploader(event) {
  const files = event.files
  if (!files || files.length === 0) return

  const authToken = localStorage.getItem('auth_token')

  if (!authToken) {
    toast.add({
      severity: 'error',
      summary: 'Authentication Error',
      detail: 'Please log in again.',
      life: 3000,
    })
    return
  }

  try {
    const formData = new FormData()
    formData.append('file', files[0])

    await $fetch(config.public.apiUrl + '/import/csv', {
      method: 'POST',
      body: formData,
      headers: {
        Authorization: `Bearer ${authToken}`,
        Accept: 'application/json',
      },
      credentials: 'include',
    })

    toast.add({
      severity: 'success',
      summary: 'Success',
      detail: 'File uploaded successfully!',
      life: 3000,
    })

    if (fileUploadRef.value) {
      fileUploadRef.value.clear()
    }
  } catch (error) {
    toast.add({
      severity: 'error',
      summary: 'Upload Failed',
      detail: error.data?.error || error.message || 'Upload failed',
      life: 3000,
    })
  }
}

async function onUpload(event) {
  console.log('Upload event:', event)
}

function onError(event) {
  toast.add({
    severity: 'error',
    summary: 'Upload Error',
    detail:
      'An error occurred during upload. Please check your file and try again.',
    life: 3000,
  })
  console.error('Upload error:', event)
}
</script>
