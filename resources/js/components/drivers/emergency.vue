<template>
    <v-layout row>
        <v-btn href="/driver/home" icon light>
            <v-icon color="grey darken-2">arrow_back</v-icon>
        </v-btn>
        <div class="text-xs-center">
            <div class="text-xs-center mt-3">
                <v-btn round large color="blue-grey darken-4" class="title font-weight-thin" @click="sendNotifyAll()" dark>Flat</v-btn>
            </div>
        </div>
    </v-layout>
</template>

<script>
export default {
    props: {
        driver: {
            type: Object,
            required: true
        }
    },
    methods: {
        sendNotifyAll() {
            axios.post('/driver/notifyAll', { id: this.driver.id, bus_id: this.driver.bus_id })
                .then(response => {
                    alert(response.data.status);
                    setTimeout(this.scrollToEnd, 100);
                });
        }
    }
};
</script>