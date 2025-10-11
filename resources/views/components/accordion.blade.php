@props(['title'])
<div
    {{$attributes->merge(['class' => 'w-full  overflow-hidden rounded-md border-2 border-gray-300 text-gray-600 dark:divide-gray-700 dark:border-gray-700 dark:text-gray-300 mb-5'])}}>
    <div x-data="{ isExpanded: false }" class=" dark:divide-gray-700">
        <button id="controlsAccordionItemOne" type="button"
            class="flex w-full items-center justify-between gap-4 bg-gray-50 p-4 text-left underline-offset-2 hover:bg-gray-50/75 focus-visible:bg-gray-50/75 focus-visible:underline focus-visible:outline-none dark:bg-gray-700 dark:hover:bg-gray-700/75 dark:focus-visible:bg-gray-700/75"  
            aria-controls="accordionItemOne" @click="isExpanded = ! isExpanded"
            :class="isExpanded ? 'text-onSurfaceStrong dark:text-onSurfaceDarkStrong font-bold' :
                'text-onSurface dark:text-onSurfaceDark font-medium'"
            :aria-expanded="isExpanded ? 'true' : 'false'">
            {{$title}}
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2"
                stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true"
                :class="isExpanded ? 'rotate-180' : ''">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>
        </button>
        <div x-cloak x-show="isExpanded" id="accordionItemOne" role="region" aria-labelledby="controlsAccordionItemOne"
            x-collapse>
            {{$slot}}
        </div>
    </div>
</div>
