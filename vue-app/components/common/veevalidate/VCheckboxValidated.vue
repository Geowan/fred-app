<template>
    <ValidationProvider :rules="rules" name="checkbox">
        <v-checkbox
            slot-scope="{ errors, valid }"
            :error-messages="errors"
            v-model="innerValue"
            type="checkbox"
            :true-value="1"
            :false-value="0"
            v-bind="$attrs"

            v-on="$listeners"
            required
        >
        </v-checkbox>
    </ValidationProvider>
</template>

<script>
    import { ValidationProvider } from "vee-validate";
    export default {
        components: {
            ValidationProvider
        },

        props: {
            rules: {
                type: [Object, String],
                default: null
            },
            value: {
                type: null
            }
        },
        data: () => ({
            innerValue: true
        }),
        watch: {
            // Handles internal model changes.
            innerValue (newVal) {
                this.$emit('input', newVal);
            },
            // Handles external model changes.
            value (newVal) {
                this.innerValue = newVal;
            }
        },
        created () {
            if (this.value) {
                this.innerValue = this.value;
            }
        }
    };
</script>
