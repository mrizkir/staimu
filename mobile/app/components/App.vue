<template>
    <Page>
        <ActionBar title="Portal Ekampus"/>
        <GridLayout columns="*" rows="*">
            <Label class="message" :text="msg" col="0" row="0"/>
        </GridLayout>
    </Page>
</template>

<script >
export default {
    data() {
      	return {
        	msg: 'Selamat datang di PortalEkampus'
      	}
    }
}
</script>

<style scoped>
    ActionBar {
        background-color: #53ba82;
        color: #ffffff;
    }

    .message {
        vertical-align: center;
        text-align: center;
        font-size: 20;
        color: #333333;
    }
</style>
