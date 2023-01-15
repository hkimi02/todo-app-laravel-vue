<template>
    <div class="categories" >
        <span class="badge text-bg-primary" v-for="categorie in categories">{{categorie.name}}</span>
    </div>
</template>
<script>
export default{
    props:{
        categories:Array,
    }
}
</script>
<style scoped>
.categories{
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr ;
    gap: 10px;
    overflow-x: auto;
}
</style>