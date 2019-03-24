<template>
    <div class="home-container">
        <ul>
            <li> Serial Number: {{ our_bike.serial_number }}</li>
            <li> Size: {{ our_bike.size }}</li>
        </ul>
    </div>
</template>
<script>

    export default {
        computed: {
            our_bike() {
                let index = this.$store.state.bike_index;
                console.log('we got index: ' + index)
                return this.$store.state.bikes[0][index];
            }
        },
    }
</script>

