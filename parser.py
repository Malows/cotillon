#! /usr/bin/env python3

import os

remplazar_usuario_db_view = lambda x: x.replace('ALGORITHM=UNDEFINED DEFINER=`juan`@`localhost` SQL SECURITY DEFINER ', '')
quitar_inline_comments = lambda x: '' if '--' == x[0:2] else x
quitar_multiline_comments = lambda x: '' if '/*' == x[0:2]  and '*/' in x[-5:] else x

referencias = {
        'ALGORITHM=UNDEFINED DEFINER=`juan`@`localhost` SQL SECURITY DEFINER ': remplazar_usuario_db_view,
        '--': quitar_inline_comments,
        '/*': quitar_multiline_comments
        }

def aplicacion(linea):
    for busca, func in referencias.items():
        if busca in linea:
            linea = func(linea)
    return linea        

lineas = []

with open('cotillon.sql', 'r') as file:
    lineas = map(aplicacion, file.readlines())



with open('localhost.sql', 'w') as file:
    file.writelines(lineas)

os.remove('cotillon.sql')
