<template>
    <modal name="new-project-modal" classes="p-4 card rounded-lg" height="auto">
        <form @submit.prevent="submit()">
            <h2 class="mb-4 font-weight-normal text-center">Let's start something new</h2>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="title" class="label">Title</label>
                        <input
                            type="text"
                            class="form-control"
                            :class="errors.title ? 'btn-outline-danger' : ''"
                            name="title"
                            id="title"
                            v-model="form.title">
                        <span class="font-italic text-danger" v-if="errors.title"><small v-text="errors.title[0]"></small></span>
                    </div>

                    <div class="form-group">
                        <label for="description" class="label">Description</label>
                        <div class="control">
                            <textarea
                                class="form-control"
                                :class="errors.description ? 'btn-outline-danger' : ''"
                                id="description"
                                name="description"
                                rows="5"
                                v-model="form.description"></textarea>
                            <span class="font-italic text-danger" v-if="errors.description"><small v-text="errors.description[0]"></small></span>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label class="label">Need some tasks?</label>
                        <input type="text"
                               class="form-control mb-2"
                               v-for="task in form.tasks"
                               placeholder="Task 1"
                               v-model="task.value">
                    </div>
                    <div class="form-group d-flex align-items-center" @click="addTask()" style="cursor: pointer;">
                        <i href="#" class="fa fa-plus-circle mr-2 text-secondary" style="font-size: 1.5rem;"></i>
                        <span class="text-xs">Add new task field</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group d-flex justify-content-end mb-0">
                        <button class="btn btn-light mr-3" type="button" @click="$modal.hide('new-project-modal')">Cancel</button>
                        <button class="btn btn-primary" type="submit">Create project</button>
                    </div>
                </div>
            </div>
        </form>
    </modal>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    title: '',
                    description: '',
                    tasks: [
                        { value: ''},
                    ]
                },

                errors: {

                }
            }
        },

        methods: {
            addTask() {
                this.form.tasks.push({ value: ''})
            },

            async submit() {
                try {
                    let response = await axios.post('/projects', this.form);
                    location = response.data.message;
                } catch (error) {
                    this.errors = error.response.data.errors;
                }
            }
        }
    }
</script>

<style scoped>

</style>
