import tkinter as tk
from tkinter import messagebox
import mysql.connector

# Conexión a MySQL
def conectar():
    return mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="escuela"
    )

# Función para insertar estudiante
def agregar_estudiante():
    nombre = entry_nombre.get()
    edad = entry_edad.get()
    correo = entry_correo.get()

    if nombre == "":
        messagebox.showwarning("Advertencia", "El nombre no puede estar vacío")
        return 
    if edad == "":
        messagebox.showwarning("Advertencia", "La edad no puede estar vacía")
        return
    if correo == "":
        messagebox.showwarning("Advertencia", "El correo no puede estar vacío")
        return

    try:
        conexion = conectar()
        cursor = conexion.cursor()

        sql = "INSERT INTO estudiantes (nombre, edad, correo) VALUES (%s, %s, %s)"
        valores = (nombre, edad, correo)

        cursor.execute(sql, valores)
        conexion.commit()

        messagebox.showinfo("Éxito", "Estudiante agregado correctamente")

        # Limpiar campos
        entry_nombre.delete(0, tk.END)
        entry_edad.delete(0, tk.END)
        entry_correo.delete(0, tk.END)

        cursor.close()
        conexion.close()

    except Exception as e:
        messagebox.showerror("Error", f"Ocurrió un error:\n{e}")

# Interfaz Tkinter
ventana = tk.Tk()
ventana.title("Registro de Estudiantes")
ventana.geometry("300x250")

# Nombre
label_nombre = tk.Label(ventana, text="Nombre del estudiante:")
label_nombre.pack(pady=5)

entry_nombre = tk.Entry(ventana, width=30)
entry_nombre.pack(pady=5)

# Edad
label_edad = tk.Label(ventana, text="Edad:")
label_edad.pack(pady=5)

entry_edad = tk.Entry(ventana, width=30)
entry_edad.pack(pady=5)

# Correo
label_correo = tk.Label(ventana, text="Correo:")
label_correo.pack(pady=5)

entry_correo = tk.Entry(ventana, width=30)
entry_correo.pack(pady=5)

# Botón
btn_agregar = tk.Button(ventana, text="Agregar", command=agregar_estudiante)
btn_agregar.pack(pady=10)

ventana.mainloop()