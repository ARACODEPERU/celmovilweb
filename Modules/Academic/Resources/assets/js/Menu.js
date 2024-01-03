import { faBook } from "@fortawesome/free-solid-svg-icons";

const menuAcademic = {
    status: false,
    text: "Académico",
    icom: faBook,
    route: null,
    permissions: "aca_dashboard",
    items: [
        {
            route: route("aca_institutions_list"),
            status: false,
            text: "Instituciones",
            permissions: "aca_institucion_listado",
        },
        {
            route: route("aca_teachers_list"),
            status: false,
            text: "Docentes",
            permissions: "aca_docente_listado",
        },
        {
            route: route("aca_students_list"),
            status: false,
            text: "Estudiantes",
            permissions: "aca_estudiante_listado",
        },
        {
            route: route("aca_courses_list"),
            status: false,
            text: "Cursos",
            permissions: "aca_cursos_listado",
        },
        {
            route: route("aca_mycourses"),
            status: false,
            text: "Mis Cursos",
            permissions: "aca_miscursos",
        },
    ],
};

export default menuAcademic;
