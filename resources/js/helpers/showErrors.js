export const showErrors = (fields, errors)=>{
    // Clear previuos styles 
    Object.values(fields).forEach(field => {

        let parent = field.parentElement;
        let span = parent.nextElementSibling;

       if(span?.tagName !== 'SPAN') return;

       // Remove border error
       parent.classList.remove('border-red-600');
       parent.classList.add('border-gay-300');
       span.classList.add('hidden')

   });

   // If have errros show in the form
   Object.keys(errors).forEach(fieldName => {
       const field = fields[fieldName];       
       if (field) {
           let parent = field.parentElement;
           let span = parent.nextElementSibling;

           if(span?.tagName !== 'SPAN') return;

           parent.classList.remove('border-gray-300');
           parent.classList.add('border-red-600');
           span.textContent = errors[fieldName];
           span.classList.remove('hidden');
       }
   });


  
}