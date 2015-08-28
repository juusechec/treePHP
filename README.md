# treePHP
Estructura de árbol en PHP para convertir las filas de la consulta SQL en una archivo JSON con jerarquía de árbol.


| id_modalidad | descripcion_modalidad | id_sede | abreviatura_sede | id_profesional | documento_persona | nombre_persona |
|---|-------------|---|---------------|---|------------|----------------|
| 1 | Medicina    | 1 | Consultorio 1 | 1 | 1000000000 | Neify Nathalya |
| 1 | Medicina    | 4 | Consultorio 1 | 1 | 1000000000 | Neify Nathalya |
| 2 | Odontología | 1 | Consultorio 1 | 1 | 1000000000 | Neify Nathalya |
| 2 | Odontología | 2 | Consultorio 2 | 2 | E01010101  | Karen Mariana  |
| 2 | Odontología | 4 | Consultorio 1 | 1 | 1000000000 | Neify Nathalya |
| 2 | Odontología | 4 | Consultorio 1 | 2 | E01010101  | Karen Mariana  |

A un JSON:
```json
[
    {
        "tipo_cita": "1",
        "nombre_cita": "MEDICINA",
        "sedes": [
            {
                "id_sede": "1",
                "abreviatura_sede": "FCMA",
                "consultorios": [
                    {
                        "id_consultorio": "1",
                        "nombre": "consultorio 1"
                    }
                ],
                "profesionales": [
                    {
                        "id_profesional": "1",
                        "nombre_persona": "Neify Nathalya",
                        "Documento de Identidad": "1000000000"
                    }
                ]
            },
            {
                "id_sede": "4",
                "abreviatura_sede": "FCMB",
                "consultorios": [
                    {
                        "id_consultorio": "3",
                        "nombre": "consultorio 1"
                    }
                ],
                "profesionales": [
                    {
                        "id_profesional": "1",
                        "nombre_persona": "Neify Nathalya",
                        "Documento de Identidad": "1000000000"
                    }
                ]
            }
        ]
    },
    {
        "tipo_cita": "2",
        "nombre_cita": "ODONTOLOGÍA",
        "sedes": [
            {
                "id_sede": "1",
                "abreviatura_sede": "FCMA",
                "consultorios": [
                    {
                        "id_consultorio": "1",
                        "nombre": "consultorio 1"
                    }
                ],
                "profesionales": [
                    {
                        "id_profesional": "1",
                        "nombre_persona": "Neify Nathalya",
                        "Documento de Identidad": "1000000000"
                    }
                ]
            },
            {
                "id_sede": "2",
                "abreviatura_sede": "FMVI",
                "consultorios": [
                    {
                        "id_consultorio": "2",
                        "nombre": "consultorio 2"
                    }
                ],
                "profesionales": [
                    {
                        "id_profesional": "2",
                        "nombre_persona": "Karen Mariana",
                        "Documento de Identidad": "E01010101"
                    }
                ]
            },
            {
                "id_sede": "4",
                "abreviatura_sede": "FCMB",
                "consultorios": [
                    {
                        "id_consultorio": "3",
                        "nombre": "consultorio 1"
                    },
                    {
                        "id_consultorio": "3",
                        "nombre": "consultorio 1"
                    }
                ],
                "profesionales": [
                    {
                        "id_profesional": "1",
                        "nombre_persona": "Neify Nathalya",
                        "Documento de Identidad": "1000000000"
                    },
                    {
                        "id_profesional": "2",
                        "nombre_persona": "Karen Mariana",
                        "Documento de Identidad": "E01010101"
                    }
                ]
            }
        ]
    }
]
```
