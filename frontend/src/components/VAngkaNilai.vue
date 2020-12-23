<template>  
    <v-text-field
        class="right-input"
        v-bind="$attrs"        
        @blur="onBlur"
        @focus="onFocus"
        @keydown="keyProcess"
        v-model.number="dataValue"
        v-on="$listeners">

    </v-text-field>  
</template>

<script>
import mixin from '@/plugins/ComponentWrappers'
export default {
    name: 'VAngkaNilai',
    mixins: [mixin],
    data: () => ({        
        fractDigitsEdited: false,
        fractPart: '0',
        isFocused:false
    }),
    methods: {
        clearValue()
        {
            this.dataValue = 0;
            this.fractPart = '0';
            this.fractDigitsEdited = false;
        },
        setFocus(val)
        {
            this.isFocused=val;
        },
        onBlur() 
        {
            this.setFocus(false);            
        },
        onFocus() 
        {
            this.setFocus(true);            
        },
        keyProcess(keyEvent)
        {
            if (!this.isFocused) return;            
            if (keyEvent.key !== 'ArrowLeft' && keyEvent.key !== 'ArrowRight') {                           
                keyEvent.preventDefault();
            }

            keyEvent.stopPropagation();
            if (keyEvent.key === 'Enter') 
            {               
                return
            } 
            else if (keyEvent.key === 'Delete') 
            {
                this.clearValue()
                return
            }            
            const numericButtons = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
            let strVal = Math.trunc(this.dataValue).toString();

            if (numericButtons.includes(keyEvent.key)) 
            {
                if (this.fractDigitsEdited && this.fractPart.length <=1) 
                {
                    if (keyEvent.key === '0') 
                    {
                        this.fractPart = keyEvent.key;
                    } 
                    else
                    {
                        this.fractPart += keyEvent.key.toString();
                    }                    
                }
                else
                {
                    strVal += keyEvent.key;                    
                }                
            } 
            else if (keyEvent.key === 'Backspace') 
            {
                if (this.fractDigitsEdited) 
                {
                    this.fractPart = this.fractPart.length <= 1 ? '0' : this.fractPart.substring(0, this.fractPart.length - 1);
                } 
                else 
                {
                    strVal = strVal.length <= 1 ? '0' : strVal.substring(0, strVal.length - 1);                   
                }
            }
            else if (['.'].includes(keyEvent.key)) 
            {
                this.fractDigitsEdited = !this.fractDigitsEdited;
            }
            strVal = strVal + '.' + this.fractPart;
            let result = parseFloat(strVal).toFixed(2);
            if (result >=0.00 && result <= 100.00)
            {
                this.dataValue=result;
            }            
        }
    },
}
</script>

<style scoped>
.right-input >>> input {
    text-align: right;
}
</style>
