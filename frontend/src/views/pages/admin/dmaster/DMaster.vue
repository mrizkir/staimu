<template>
    <DataMasterLayout>
        <ModuleHeader>
            <template v-slot:icon>
                mdi-google-classroom
            </template>
            <template v-slot:name>
                DATA MASTER
            </template>
            <template v-slot:breadcrumbs>
                <v-breadcrumbs :items="breadcrumbs" class="pa-0">
                    <template v-slot:divider>
                        <v-icon>mdi-chevron-right</v-icon>
                    </template>
                </v-breadcrumbs>
            </template>
            <template v-slot:desc>
                <v-alert
                    color="cyan"
                    border="left"
                    colored-border
                    type="info"
                    >
                    Pengaturan berbagai parameter sebagai referensi dari modul-modul lain dalam sistem.
                </v-alert>
            </template>
        </ModuleHeader>
    </DataMasterLayout>
</template>
<script>
import DataMasterLayout from '@/views/layouts/DataMasterLayout';
import ModuleHeader from '@/components/ModuleHeader';
export default {
    name: "DMaster",
    components: {
        DataMasterLayout,
        ModuleHeader,
    },
}
</script>