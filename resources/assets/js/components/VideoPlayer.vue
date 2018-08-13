<template>
    <video width="100%" height="100%" controls>
        <source :src="video.video_url" type="video/mp4" :key="video.video_url"> Your browser does not support the video tag.
    </video>
</template>

<script>
export default {
    props: ['video']
}
</script>
