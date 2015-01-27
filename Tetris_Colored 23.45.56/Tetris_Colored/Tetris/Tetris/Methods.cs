using System;
using System.Collections.Generic;
using System.Text;
using System.Drawing;

namespace TetrisGame
{
    public static class Methods
    {
        /// <summary>
        ///  Проверка записи предмета в матрицу
        /// </summary>
        /// <param name="item">Координаты предмета</param>
        /// <returns>Ложь- нельзя записать</returns>
        
        public static bool TryFlashMatrix(Point[] item, byte[][] matrix, Point[] pos)
        {
            foreach (Point p in item)
            {
                if ((p.X < 0) || (p.X > 19))
                    return false;
                if ((p.Y < 0) || (p.Y > 7))
                    return false;
                if (matrix[p.X][p.Y] == 1)
                    return false;
            }
            FlashMatrix(item, matrix, pos);
            return true;
        }

        /// <summary>
        /// Процедура записи текущего предмета в матрицу
        /// </summary>
        /// <param name="item">Координаты предмета</param>
        
        public static void FlashMatrix(Point[] item, byte[][] matrix, Point[] pos)
        {
            for (int i = 0; i < 20; i++)
                for (int y = 0; y < 10; y++)
                    if (matrix[i][y] == 2) matrix[i][y] = 0;
            foreach (Point p in item)
                matrix[p.X][p.Y] = 2;
            // Нужно для соблюдения порядка точек
            byte c = 0;
            for (int i = 0; i < 20; i++)
                for (int y = 0; y < 10; y++)
                    if (matrix[i][y] == 2)
                    {
                        pos[c] = new Point(i, y);
                        c++;
                        if (c == 4) break;
                    }
        }

        /// <summary>
        /// Записывает текущую фигуру в матрицу
        /// </summary>
        public static void FlashMatrix(byte[][] matrix)
        {
            for (int i = 0; i < 20; i++)
                for (int y = 0; y < 10; y++)
                    if (matrix[i][y] == 2) matrix[i][y] = 1;
        }
        public static Point[] Step(byte[][] matrix)
        {
            Point[] pts;
            /// Список точек текущего предмета
            List<Point> pt = new List<Point>();
            for (byte i = 0; i < 20; i++)
                for (byte y = 0; y < 10; y++)
                    if (matrix[i][y] == 2)
                    {
                        pt.Add(new Point(i, y));
                    }
            foreach (Point p in pt)
            {
                if (p.X == 19)
                {
                    FlashMatrix(matrix);
                    return null;
                }
                if (matrix[p.X + 1][p.Y] == 1)
                {
                    FlashMatrix(matrix);
                    return null;
                }
            }
            // Если не найдено препятствие
            // Двигаем предмет
            /// Переписываем точки для вызова процедуры
            pts = new Point[pt.Count];
            for (byte i = 0; i < pt.Count; i++)
            {
                pt[i] = new Point(pt[i].X + 1, pt[i].Y);
                pts[i] = pt[i];
            }
            return pts;
        }
        public static Point[] ShiftLeft(byte[][] matrix)
        {
            Point[] pts;
            /// Список точек текущего предмета
            List<Point> pt = new List<Point>();
            for (byte i = 0; i < 20; i++)
                for (byte y = 0; y < 10; y++)
                    if (matrix[i][y] == 2)
                    {
                        pt.Add(new Point(i, y));
                    }
            foreach (Point p in pt)
            {
                if (p.Y == 0)
                {
                    return null;
                }
                if (matrix[p.X][p.Y - 1] == 1)
                {
                    return null;
                }
            }
            // Если не найдено препятствие
            // Двигаем предмет
            /// Переписываем точки для вызова процедуры
            pts = new Point[pt.Count];
            for (byte i = 0; i < pt.Count; i++)
            {
                pt[i] = new Point(pt[i].X, pt[i].Y - 1);
                pts[i] = pt[i];
            }
            return pts;
        }
        public static Point[] ShiftRight(byte[][] matrix)
        {
            Point[] pts;
            /// Список точек текущего предмета
            List<Point> pt = new List<Point>();
            for (byte i = 0; i < 20; i++)
                for (byte y = 0; y < 10; y++)
                    if (matrix[i][y] == 2)
                    {
                        pt.Add(new Point(i, y));
                    }
            foreach (Point p in pt)
            {
                if (p.Y == 9)
                {
                    return null;
                }
                if (matrix[p.X][p.Y + 1] == 1)
                {
                    return null;
                }
            }
            // Если не найдено препятствие
            // Двигаем предмет
            // Переписываем точки для вызова процедуры
            pts = new Point[pt.Count];
            for (byte i = 0; i < pt.Count; i++)
            {
                pt[i] = new Point(pt[i].X, pt[i].Y + 1);
                pts[i] = pt[i];
            }
            return pts;
        }
    }
}
