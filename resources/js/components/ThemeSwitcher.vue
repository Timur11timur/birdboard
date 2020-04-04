<template>
    <div class="d-flex align-items-center mr-4">
       <button v-for="(color, theme) in themes"
                class="mr-2 rounded-circle p-2"
               :class="{ 'border-primary': selectedTheme == theme }"
               :style="{ backgroundColor: color }"
               @click="selectedTheme = theme"></button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                themes: {
                    'theme-light' : '#f8fafc',
                    'theme-dark' : '#1b1e21',
                    'theme-orange' : 'orange',
                },
                selectedTheme: 'theme-light'
            };
        },

        created() {
            this.selectedTheme = localStorage.getItem('theme') || 'theme-light';
        },

        watch: {
            selectedTheme() {
                document.body.className = document.body.className.replace(/theme-\w+/, this.selectedTheme);

                localStorage.setItem('theme', this.selectedTheme);
                //this.$emit('changed', this.selectedTheme);
                //alert('changed');
            }
        }
    }
</script>
