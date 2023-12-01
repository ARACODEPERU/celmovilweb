<template>
    <DataTable class="display">
                        <thead>
                            <tr>
                                <th>First</th>
                                <th>Second</th>
                            </tr>
                        </thead>
                    </DataTable>
  </template>
  
  <script>
  import DataTable from 'datatables.net-vue3';
    import DataTablesCore from 'datatables.net';
    DataTable.use(DataTablesCore);
  export default {
    name: 'ChildComponent',
    // Agrega la ruta al archivo CSS del componente hijo aquí
    styles: ['/css/child-component.css']
  }
  </script>
  