<template>
	<BlogLayout :temporaryleftsidebar="true" :temporaryrightsidebar="false">
		<ModuleHeader>
			<template v-slot:icon>
				mdi-google-classroom
			</template>
			<template v-slot:name>
				INFO KAMPUS
			</template>
			<template v-slot:breadcrumbs>
				<v-breadcrumbs :items="breadcrumbs" class="pa-0">
					<template v-slot:divider>
						<v-icon>mdi-chevron-right</v-icon>
					</template>
				</v-breadcrumbs>
			</template>
			<template v-slot:desc>
				<v-alert color="cyan" border="left" colored-border type="info">
					Halaman untuk mengelola informasi seputar kampus
				</v-alert>
			</template>
		</ModuleHeader>
		<template v-slot:filtersidebar>
			<v-list-item>
				<v-list-item-icon class="mr-2">
					<v-icon>mdi-menu-open</v-icon>
				</v-list-item-icon>
				<v-list-item-content>
					<v-list-item-title class="title">
						OPTIONS
					</v-list-item-title>
				</v-list-item-content>
			</v-list-item>
			<v-divider></v-divider>
		</template>
		<v-container fluid v-if="INFO_KAMPUS_TERM_ID">
			<v-row class="mb-4" no-gutters>
				<v-col cols="12">
					<v-form ref="frmdata" v-model="form_valid" lazy-validation>
						<v-card>
							<v-card-title>
								<span class="headline">TAMBAH INFORMASI</span>
							</v-card-title>
							<v-card-text>
								<v-text-field
									v-model="formdata.post_title"
									label="JUDUL INFORMASI"
									outlined
									:rules="rule_judul"
								/>
								<tiptap-vuetify
									v-model="formdata.post_content"
									:extensions="extensions"
									:rules="rule_content"
								/>
							</v-card-text>
							<v-card-actions>
								<v-btn
									color="blue darken-1"
									text
									@click.stop="$router.push('/blog/pages/infokampus')"
								>
									BATAL
								</v-btn>
								<v-spacer></v-spacer>
								<v-btn
									color="blue darken-1"
									text
									@click.stop="save"
									:disabled="!form_valid || btnLoading"
								>
									SIMPAN
								</v-btn>
							</v-card-actions>
						</v-card>
					</v-form>
				</v-col>
			</v-row>
		</v-container>
		<v-container fluid v-else>
			<v-row>
				<v-col cols="12">
					<v-alert type="info">
						KATEGORI untuk Info Kampus belum disetting.
					</v-alert>
				</v-col>
			</v-row>
		</v-container>
	</BlogLayout>
</template>
<script>
	import BlogLayout from "@/views/layouts/BlogLayout";
	import ModuleHeader from "@/components/ModuleHeader";
	import {
		// component
		TiptapVuetify,
		// extensions
		Heading,
		Bold,
		Italic,
		Strike,
		Underline,
		Code,
		CodeBlock,
		Paragraph,
		BulletList,
		OrderedList,
		ListItem,
		Link,
		Blockquote,
		HardBreak,
		HorizontalRule,
		History,
	} from "tiptap-vuetify";

	export default {
		name: "PageInfoKampus",
		created() {
			this.breadcrumbs = [
				{
					text: "HOME",
					disabled: false,
					href: "/dashboard/" + this.$store.getters["auth/Token"],
				},
				{
					text: "BLOG",
					disabled: false,
					href: "/blog",
				},
				{
					text: "INFO KAMPUS",
					disabled: false,
					href: "/blog/pages/infokampus",
				},
				{
					text: "TAMBAH",
					disabled: true,
					href: "#",
				},
			];
		},
		mounted() {
			this.fetchConfig();
		},
		data: () => ({
			firstloading: true,
			btnLoading: false,

			//page config
			INFO_KAMPUS_TERM_ID: null,

			//tiptap extension
			extensions: [
				History,
				Blockquote,
				Link,
				Underline,
				Strike,
				Italic,
				ListItem,
				BulletList,
				OrderedList,
				[
					Heading,
					{
						options: {
							levels: [1, 2, 3],
						},
					},
				],
				Bold,
				Code,
				CodeBlock,
				HorizontalRule,
				Paragraph,
				HardBreak,
			],

			//form data
			form_valid: true,
			formdata: {
				post_title: "",
				post_content: ``,
			},
			formdefault: {
				post_title: "",
				post_content: ``,
			},

			//form rules
			rule_judul: [
				value => !!value || "Mohon judul informasi untuk di isi !!!",
			],
			rule_content: [
				value => !!value || "Mohon konten informasi untuk di isi !!!",
			],
		}),
		methods: {
			async fetchConfig() {
				await this.$ajax
					.get("/blog/pages/infokampus/config", {
						headers: {
							Authorization: this.$store.getters["auth/Token"],
						},
					})
					.then(({ data }) => {
						this.INFO_KAMPUS_TERM_ID = data.config.INFO_KAMPUS_TERM_ID;
					});
				this.firstloading = false;
			},
			save: async function() {
				if (this.$refs.frmdata.validate()) {
					this.btnLoading = true;
					await this.$ajax
						.post(
							"/blog/pages/infokampus/store",
							{
								post_title: this.formdata.post_title,
								post_content: this.formdata.post_content,
								term_id: this.INFO_KAMPUS_TERM_ID,
							},
							{
								headers: {
									Authorization: this.$store.getters["auth/Token"],
								},
							}
						)
						.then(({ data }) => {
							this.btnLoading = false;
							this.$router.push("/blog/pages/infokampus/" + data.post.id + "/edit");
						})
						.catch(() => {
							this.btnLoading = false;
						});
				}
			},
		},
		components: {
			BlogLayout,
			TiptapVuetify,
			ModuleHeader,
		},
	};
</script>
