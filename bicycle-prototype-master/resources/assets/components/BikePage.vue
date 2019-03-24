<template>
    <div class="home-container">
        <table>
            <thead>
                <tr>
                    <td>Serial Nr.</td>
                    <td>Category</td>
                    <td>Size</td>
                </tr>
            </thead>

            <tbody v-for="(bike, index) in bike_summaries">
                <tr @click.stop="select_bike(index)">
                    <td>{{ bike.serial_number }}</td>
                    <td>{{ bike.category }}</td>
                    <td>{{ bike.size }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>

    export default {
        computed: {
            bike_summaries() { // todo simplify - this is an array with one element which is an array of bikes
                return this.$store.state.bikes[0];
            }
        },
        methods: {
            select_bike(index) {
                this.$store.commit('setBikeIndex', index);
                //this.$emit('select-bike', index);
                window.location = 'http://bicycle.test/bikes/' + index // todo check out how it should be done the Vue.js way?
            }
        },
    }
</script>
