<template>
    <div>
        <v-app-bar app>
            <v-toolbar-title>
                <span class="hidden-sm-and-down">{{namaPTAlias}}</span>
            </v-toolbar-title>
            <v-spacer />
            <v-btn to="/" class="mr-2" color="primary" text large>
                Home
            </v-btn>
            <v-btn to="/pmb" class="mr-2" color="primary" text large>
                PENDAFTARAN
            </v-btn>
            <v-btn to="/login" color="primary" text large>
                Login
            </v-btn>
        </v-app-bar>
        <v-main>
            <slot/>
        </v-main>
        <v-footer app padless fixed>
			<v-card class="flex" color="yellow darken-2" flat tile>
				<v-divider></v-divider>
				<v-card-text class="py-2 black--text text-center">
					<strong>{{ APP_NAME }} (2021-2021)</strong> dikembangkan oleh TIM IT STAI Miftahul 'Ulum Tanjungpinang 
					<v-btn icon href="https://github.com/mrizkir/stiemu">
						<v-icon>mdi-github</v-icon>
					</v-btn>
				</v-card-text>
			</v-card>
		</v-footer>  
    </div>
</template>
<script>
import { mapGetters } from "vuex";

export default {
    name: 'FrontLayout',
    created()
    {
        this.$store.dispatch('uifront/init',this.$ajax);  
    },
    computed : {
        APP_NAME()
        {
            return process.env.VUE_APP_NAME;
        },
        ...mapGetters("uifront", {
            namaPTAlias: 'getNamaPTAlias'
        })
    }
}
</script>