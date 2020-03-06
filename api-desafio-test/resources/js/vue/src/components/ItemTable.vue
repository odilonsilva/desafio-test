<template>
    <tr>
        <td>{{ element.id}}</td>
        <td>{{ element.name}}</td>
        <td>{{ element.email}}</td>
    </tr>
</template>

<script>
export default {
    name:'ItemTable',
    props:['element']
}
</script>