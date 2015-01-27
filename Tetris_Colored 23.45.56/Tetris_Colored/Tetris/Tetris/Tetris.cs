using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;

namespace TetrisGame
{
    public partial class Tetris : Form
    {
        public Tetris()
        {
            InitializeComponent();
        }

        #region Vars
        /// <summary>
        ///  Матрица с игровым полем. 0 - пусто. 1 - полно (: 2 - текущий блок 3 - центр текущего блока
        /// </summary>
        byte[][] matrix = null;
        public byte[][] Matrix { get { return matrix; } }
        /// <summary>
        /// Началась ли игра?
        /// </summary>
        bool isGame = false;
        /// <summary>
        /// Уровень
        /// </summary>
        public byte lvl=1;
        /// <summary>
        /// Очки
        /// </summary>
        int score = 0;
        /// <summary>
        /// Убранные линии
        /// </summary>
        int lines = 0;
        /// <summary>
        /// Скорость игры.
        /// </summary>
        byte speed = 1;
        /// <summary>
        /// Класс для рисования
        /// </summary>
        Graphics g = null;
        /// <summary>
        /// Размер одной ячейки.
        /// Х - width(ширина), Y - height(высота)
        /// </summary>
        Point blockSize = new Point();
        /// <summary>
        /// Размер одной ячейки в окне next.
        /// Х - width(ширина), Y - height(высота)
        /// </summary>
        Point blockNextSize = new Point();
        /// <summary>
        /// Генератор псевдослучайных чисел ,
        /// </summary>
        Random rnd = new Random();
        /// <summary>
        /// Текущий Положение Текущего Компонета
        /// </summary>
        Point[] pos = new Point[4];
        /// <summary>
        /// Угол поворота (0 - std, 1, 2)
        /// </summary>
        byte angle = 0;
        /// <summary>
        /// Тип фигуры
        /// 0 - чтука похожая на Т. 1 - квадрат но со сдвинутой в право верхушкой. 2 - тоже самое только влево.
        /// 3 - фигура похожая на букву Г. 4 - тоже самое только влево. 5 - квадрат. 6 - прямая.
        /// </summary>
        byte type = 0;
        /// <summary>
        /// Тип Следущей фигруры
        /// </summary>
        byte nextType = 0;
        /// <summary>
        /// Определяет остановлена ли игра.
        /// </summary>
        bool isPause = false;
        #endregion

        #region Functions
        /// <summary>
        /// Включить/Выключить Паузу
        /// </summary>
        void SwitchPause()
        {
            if (isPause)
                time.Start();
            else
                time.Stop();
            isPause = !isPause;
        }
        /// <summary>
        /// Создает массив координат точек указанной  фигуры
        /// </summary>
        /// <param name="type">Номер фигуры. От 0 до 6</param>
        /// <returns>Координаты указанной фигуры</returns>
        Point[] GetItem(byte type)
        {
            Point[] pt = new Point[4];
            switch (type)
            {
                case 0: // T
                    type = 0;
                    pt[0].X = 0; pt[0].Y = 3;
                    pt[1].X = 0; pt[1].Y = 4;
                    pt[2].X = 0; pt[2].Y = 5;
                    pt[3].X = 1; pt[3].Y = 4;
                    break;
                case 1: // S
                    type = 1;
                    pt[0].X = 1; pt[0].Y = 3;
                    pt[1].X = 1; pt[1].Y = 4;
                    pt[2].X = 0; pt[2].Y = 4;
                    pt[3].X = 0; pt[3].Y = 5;
                    break;
                case 2: // !S
                    type = 2;
                    pt[0].X = 0; pt[0].Y = 3;
                    pt[1].X = 0; pt[1].Y = 4;
                    pt[2].X = 1; pt[2].Y = 5;
                    pt[3].X = 1; pt[3].Y = 4;
                    break;
                case 3: // Г
                    type = 3;
                    pt[0].X = 0; pt[0].Y = 3;
                    pt[1].X = 0; pt[1].Y = 4;
                    pt[2].X = 0; pt[2].Y = 5;
                    pt[3].X = 1; pt[3].Y = 3;
                    break;
                case 4: // !Г 
                    type = 4;
                    pt[0].X = 0; pt[0].Y = 3;
                    pt[1].X = 0; pt[1].Y = 4;
                    pt[2].X = 0; pt[2].Y = 5;
                    pt[3].X = 1; pt[3].Y = 5;
                    break;
                case 5: // о
                    type = 5;
                    pt[0].X = 0; pt[0].Y = 3;
                    pt[1].X = 0; pt[1].Y = 4;
                    pt[2].X = 1; pt[2].Y = 3;
                    pt[3].X = 1; pt[3].Y = 4;
                    break;
                default: // |
                    type = 6;
                    pt[0].X = 0; pt[0].Y = 3;
                    pt[1].X = 0; pt[1].Y = 4;
                    pt[2].X = 0; pt[2].Y = 5;
                    pt[3].X = 0; pt[3].Y = 2;
                    break;
            }
            return pt;
        }
        /// <summary>
        /// Удаляем строку из матрицы
        /// </summary>
        /// <param name="row">Строка для удаления</param>
        void FlashRow(byte row)
        {
            for (int i = row; i > 0; i--)
            {
                matrix[i] = matrix[i - 1];
            }
            byte[] tmp = { 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 };
            matrix[0] = tmp;  // ,
            lines++;
            score += speed * lines;
        }

        /// <summary>
        /// Определяет шаг игры
        /// </summary>
        /// <returns> Истина если нужен новый предмет итекущий предмет дошел до низа</returns>
        bool Step()
        {
            Point[] pts = Methods.Step(matrix);
            if (pts == null) return false;
            // Записываем фигуру
            Methods.FlashMatrix(pts, matrix, pos);
            return true;
        }
        /// <summary>
        /// Движение фигуры влево
        /// </summary>
        /// <returns>Истина - передвинули, ложиь-не передвинули</returns>
        bool ShiftLeft()
        {
            Point[] pts = Methods.ShiftLeft(matrix);
            if (pts == null) return false;
            // Записываем фигуру
            Methods.FlashMatrix(pts, matrix, pos);
            return true;
        }
        /// <summary>
        /// Движение фигуры вправо
        /// </summary>
        /// <returns>Истина - передвинули, ложиь-не передвинули</returns>
        bool ShiftRight()
        {
            Point[] pts = Methods.ShiftRight(matrix);
            if (pts == null) return false;
            // Записываем фигуру
            Methods.FlashMatrix(pts, matrix, pos);
            return true;
        }

        /// <summary>
        /// Вращение фигуры
        /// </summary>
        /// <returns>Истина - развернули</returns>
        bool rotate()
        {  
            Point[] pt = new Point[4];
            switch (this.type)
            {
                case 0: // T 
                    switch (this.angle)
                    {
                        case 0:
                            for (byte i = 0; i < 4; i++ )
                                pt[i] = this.pos[i];  
                            pt[2] = new Point(pt[2].X - 1, pt[2].Y - 1);
                            if (Methods.TryFlashMatrix(pt, matrix, pos))
                                this.angle++;
                            break;
                        case 1:  
                            for (byte i = 0; i < 4; i++)
                                pt[i] = this.pos[i];
                            pt[3] = new Point(pt[3].X - 1, pt[3].Y + 1);
                            if (Methods.TryFlashMatrix(pt, matrix, pos))
                                this.angle++;
                            break;
                        case 2:
                            for (byte i = 0; i < 4; i++)
                                pt[i] = this.pos[i];
                            pt[1] = new Point(pt[1].X + 1, pt[1].Y + 1);
                            if (Methods.TryFlashMatrix(pt, matrix, pos))
                                this.angle++;
                            break;
                        case 3:
                            for (byte i = 0; i < 4; i++)
                                pt[i] = this.pos[i];
                            pt[0] = new Point(pt[0].X + 1, pt[0].Y - 1);
                            if (Methods.TryFlashMatrix(pt, matrix, pos))
                                this.angle = 0;
                            break;
                    }
                    break;
                case 1:
                    for (byte i = 0; i < 4; i++)
                            pt[i] = this.pos[i];
                    if (angle == 0)
                    {
                        pt[1] = new Point(pt[1].X + 2, pt[1].Y);
                        pt[2] = new Point(pt[2].X, pt[2].Y + 2);
                        if (Methods.TryFlashMatrix(pt, matrix, pos))
                            this.angle = 1;
                    }
                    else
                    {
                        pt[2] = new Point(pt[2].X, pt[2].Y - 2);
                        pt[3] = new Point(pt[3].X - 2, pt[3].Y);
                        if (Methods.TryFlashMatrix(pt, matrix, pos))
                            this.angle = 0;
                    }
                    break;
                case 2:
                    for (byte i = 0; i < 4; i++)
                        pt[i] = this.pos[i];
                    if (angle == 0)
                    {
                        pt[0] = new Point(pt[0].X + 2, pt[0].Y);
                        pt[3] = new Point(pt[3].X, pt[3].Y - 2);
                        if (Methods.TryFlashMatrix(pt, matrix, pos))
                            this.angle = 1;
                    }
                    else
                    {
                        pt[1] = new Point(pt[1].X, pt[1].Y + 2);
                        pt[3] = new Point(pt[3].X - 2, pt[3].Y );
                        if (Methods.TryFlashMatrix(pt, matrix, pos))
                            this.angle = 0;
                    }                       
                    break;
                case 3:
                    switch (this.angle)
                    {
                        case 0:
                            for (byte i = 0; i < 4; i++)
                                pt[i] = this.pos[i];
                            pt[0] = new Point(pt[0].X - 1, pt[0].Y);
                            pt[2] = new Point(pt[2].X - 1, pt[2].Y - 1);
                            pt[3] = new Point(pt[3].X, pt[3].Y + 1);
                            if (Methods.TryFlashMatrix(pt, matrix, pos))
                                this.angle++;
                            break;
                        case 1:
                            for (byte i = 0; i < 4; i++)
                                pt[i] = this.pos[i];
                            pt[0] = new Point(pt[0].X + 1, pt[0].Y);
                            pt[1] = new Point(pt[1].X, pt[1].Y + 1);
                            pt[3] = new Point(pt[3].X - 1, pt[3].Y + 1);
                            if (Methods.TryFlashMatrix(pt, matrix, pos))
                                this.angle++;
                            break;
                        case 2:
                            for (byte i = 0; i < 4; i++)
                                pt[i] = this.pos[i];
                            pt[0] = new Point(pt[0].X, pt[0].Y - 1);
                            pt[1] = new Point(pt[1].X + 1, pt[1].Y + 1);
                            pt[3] = new Point(pt[3].X + 1, pt[3].Y);
                            if (Methods.TryFlashMatrix(pt, matrix, pos))
                                this.angle++;
                            break;
                        case 3:
                            for (byte i = 0; i < 4; i++)
                                pt[i] = this.pos[i];
                            pt[0] = new Point(pt[0].X + 1, pt[0].Y - 1);
                            pt[2] = new Point(pt[2].X, pt[2].Y - 1);
                            pt[3] = new Point(pt[3].X - 1, pt[3].Y);
                            if (Methods.TryFlashMatrix(pt, matrix, pos))
                                this.angle = 0;
                            break;
                    } 
                    break;
                case 4:
                    switch (this.angle)
                    {
                        case 0:
                            for (byte i = 0; i < 4; i++)
                                pt[i] = this.pos[i];
                            pt[0] = new Point(pt[0].X - 1, pt[0].Y + 1);
                            pt[2] = new Point(pt[2].X + 1, pt[2].Y - 1);
                            pt[3] = new Point(pt[3].X, pt[3].Y - 2);
                            if (Methods.TryFlashMatrix(pt, matrix, pos))
                                this.angle++;
                            break;
                        case 1:
                            for (byte i = 0; i < 4; i++)
                                pt[i] = this.pos[i];
                            pt[0] = new Point(pt[0].X + 1, pt[0].Y + 1);
                            pt[2] = new Point(pt[2].X - 2, pt[2].Y );
                            pt[3] = new Point(pt[3].X - 1, pt[3].Y - 1);
                            if (Methods.TryFlashMatrix(pt, matrix, pos))
                                this.angle++;
                            break;
                        case 2:
                            for (byte i = 0; i < 4; i++)
                                pt[i] = this.pos[i];
                            pt[0] = new Point(pt[0].X, pt[0].Y + 1);
                            pt[1] = new Point(pt[1].X + 1, pt[1].Y + 1);
                            pt[3] = new Point(pt[3].X - 1, pt[3].Y);
                            if (Methods.TryFlashMatrix(pt, matrix, pos))
                                this.angle++;
                            break;
                        case 3:
                            for (byte i = 0; i < 4; i++)
                                pt[i] = this.pos[i];
                            pt[0] = new Point(pt[0].X + 1, pt[0].Y + 1);
                            pt[1] = new Point(pt[1].X + 2, pt[1].Y);
                            pt[3] = new Point(pt[3].X - 1, pt[3].Y - 1);
                            if (Methods.TryFlashMatrix(pt, matrix, pos))
                                this.angle = 0;
                            break;
                    }
                    break;
                case 5: // квадрат
                    break;
                case 6:
                    if (this.angle == 0)
                    {
                        pt[1] = this.pos[1];
                        pt[0] = new Point(pt[1].X - 1, pt[1].Y);
                        pt[2] = new Point(pt[1].X + 1, pt[1].Y);
                        pt[3] = new Point(pt[1].X + 2, pt[1].Y);

                        if (Methods.TryFlashMatrix(pt, matrix, pos))
                            this.angle = 1;
                    }
                    else
                    {
                        pt[1] = this.pos[1];
                        pt[0] = new Point(pt[1].X, pt[1].Y - 1);
                        pt[2] = new Point(pt[1].X, pt[1].Y + 1);
                        pt[3] = new Point(pt[1].X, pt[1].Y + 2);
                        if (Methods.TryFlashMatrix(pt, matrix, pos))
                            this.angle = 0;
                    }
                    break;
            }
            return false;
        }

        /// <summary>
        /// Рисование картинки по текущей матрице
        /// </summary>
        void FlashImage()
        {
            g.Clear(Color.DimGray);
            for (int i = 0; i < 20; i++)
                for (int y = 0; y < 10; y++)
                {
                    if ((matrix[i][y] == 2) & (type == 0))
                        g.FillRectangle(Brushes.Aqua, y * blockSize.X, i * blockSize.Y,
                            blockSize.X - 1, blockSize.Y - 1);
                    if ((matrix[i][y] == 2) & ((type == 1) || (type == 2)))
                        g.FillRectangle(Brushes.Fuchsia, y * blockSize.X, i * blockSize.Y,
                        blockSize.X - 1, blockSize.Y - 1);
                    if ((matrix[i][y] == 2 & ((type == 3) || (type == 4))))
                        g.FillRectangle(Brushes.Coral, y * blockSize.X, i * blockSize.Y,
                        blockSize.X - 1, blockSize.Y - 1);
                    if ((matrix[i][y] == 2) & ((type == 5)))
                        g.FillRectangle(Brushes.GreenYellow, y * blockSize.X, i * blockSize.Y,
                        blockSize.X - 1, blockSize.Y - 1);
                    if ((matrix[i][y] == 2) & ((type == 6)))
                        g.FillRectangle(Brushes.Yellow, y * blockSize.X, i * blockSize.Y,
                        blockSize.X - 1, blockSize.Y - 1);
                    else if (matrix[i][y] == 1)
                        g.FillRectangle(Brushes.Indigo, y * blockSize.X, i * blockSize.Y,
                        blockSize.X - 1, blockSize.Y - 1);
                   
                }
            main.Refresh();
        }

        /// <summary>
        /// Прорисовка следущей фигуры
        /// </summary>
        void FlashNextImage()
        {
            Graphics g = Graphics.FromImage(this.next.Image);
            g.Clear(Color.DimGray);
            Point[] pt = GetItem(this.nextType);
            foreach (Point p in pt)
                g.FillRectangle(Brushes.DarkGray, (p.Y - 2) * blockNextSize.X, (p.X) * blockNextSize.Y,
                            blockNextSize.X - 1, blockNextSize.Y - 1);
            this.next.Refresh();
        }
        #endregion

        private void новаяИграToolStripMenuItem_Click(object sender, EventArgs e)
        {
            /// Создаем новую матрицу
            this.matrix = new byte[20][];
            for (int i = 0; i < 20; i++)
                this.matrix[i] = new byte[10];
            /// Создаем новую картинку
            this.isGame = true;
            this.isPause = false;
            this.Tetris_Resize(sender, null);
            this.type = (byte)rnd.Next(7);

            angle = 0;
            score = 1;
            lines = 0;
            speed = this.lvl;
            time.Interval = ((1000 - (speed - 1) * 100) <= 1) ? 10 : (1000 - (speed - 1) * 100); 
            /// Включаем Игру
            Methods.FlashMatrix(GetItem(this.type), matrix, pos);
            this.time.Start();
        }

        /// <summary>
        /// Обработка Игры
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void time_Tick(object sender, EventArgs e)
        {
            // делаем шаг и определяем последний ли 
            // он для текущего элемента
            if (!Step())
            {   
                // Если шаг последний, то смотрим есть ли заполненая строка
                for (byte i = 0; i < 20; i++)
                {
                    byte check = 0;
                    foreach (byte b in matrix[i])
                        if (b == 1)
                            check++;
                        else
                            break;
                    /// удаляем строку
                    if (check == 10)
                    {
                        FlashRow(i);
                        if (lines % (5 * speed) == 0)
                        {
                            speed++;
                            time.Interval = ((1000 - (speed - 1) * 100) <= 1) ? 10 : (1000 - (speed - 1) * 100);
                            lLevel.Text = Convert.ToString(this.speed);
                        }
                        lScore.Text = Convert.ToString(this.score);
                        lLines.Text = Convert.ToString(this.lines);
                    }
                }
                // делаем новую фигуру
                // задаем текущию фигуру из следущей
                this.type = this.nextType;
                // и находим следущию
                this.nextType = (byte)this.rnd.Next(7);
                // указываем о том что новая фигура не повернута
                this.angle = 0;
                // и записываем ее в матрицу
                if (!Methods.TryFlashMatrix(GetItem(this.type),matrix, pos))
                    // Конец Игры
                {
                    isGame = false;
                    time.Stop();
                    if (MessageBox.Show(
                        this,
                        String.Format("Вы Проиграли!\n Вы собрали {0} линий на {1} уровне и заработали {2} очков.\n Хотите поиграть еще?",
                            this.lines,
                            this.speed,
                            this.score),
                        "[dsb] Тетрись", 
                        MessageBoxButtons.YesNo, 
                        MessageBoxIcon.Stop) == DialogResult.Yes)
                    {
                        this.новаяИграToolStripMenuItem_Click(sender, null);
                        return;
                    }
                    return;
                }
                // рисуем следущию фигуру с краю формы
                FlashNextImage();
            }
            // Перерисовываем картинку
            FlashImage();
        }


        /// <summary>
        /// Происходит при изменении размера формы
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void Tetris_Resize(object sender, EventArgs e)
        {
            if (!isGame)
                return;
            this.main.Image = new Bitmap(this.main.Width, this.main.Height);
            this.next.Image = new Bitmap(this.next.Width, this.main.Height);
            this.g = Graphics.FromImage(this.main.Image);
            blockSize.X = (int)(this.main.Width / 10);
            blockSize.Y = (int)(this.main.Height / 20);
            blockNextSize.X = (int)(this.next.Width / 4);
            blockNextSize.Y = (int)(this.next.Height / 2);
            FlashImage();
            FlashNextImage();
        }

        /// <summary>
        /// Обработка клавиш
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void Tetris_PreviewKeyDown(object sender, PreviewKeyDownEventArgs e)
        {
            if (e.KeyData == Keys.Space)
            {
                if (!isGame)
                    return;
                SwitchPause();
            }
            else
            {
                if (!isGame || isPause)    //**
                    return;
                switch (e.KeyData)
                {
                    case Keys.Up:
                        rotate();
                        break;
                    case Keys.Left:
                        this.ShiftLeft();
                        break;
                    case Keys.Right:
                        this.ShiftRight();
                        break;
                    case Keys.Down:
                        /// Список точек текущего предмета
                        bool bad = false;
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
                                bad = true;
                                break;
                            }
                            if (matrix[p.X + 1][p.Y] == 1)
                            {
                                bad = true;
                                break;
                            }
                        }
                        // Если не найдено препятствие
                        if (!bad)
                        {
                            // Двигаем предмет
                            /// Переписываем точки для вызова процедуры
                            Point[] pts = new Point[pt.Count];
                            for (byte i = 0; i < pt.Count; i++)
                            {
                                pt[i] = new Point(pt[i].X + 1, pt[i].Y);
                                pts[i] = pt[i];
                            }
                            // Записываем фигуру
                            Methods.FlashMatrix(pts, matrix, pos);
                        }
                        break;
                    default:
                        return;
                }
                FlashImage();
            }
        }

        /// <summary>
        ///  Выходит из игры
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void выходToolStripMenuItem_Click(object sender, EventArgs e)
        {
            Application.Exit();
        }


        /// <summary>
        /// Ставит игру на паузу
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void паузаToolStripMenuItem_Click(object sender, EventArgs e)
        {
            if (!isGame)
                return;
            SwitchPause();       //**
        }


        /// <summary>
        /// Cправка Игры
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void справкаToolStripMenuItem_Click(object sender, EventArgs e)
        {
            if (!isPause)
                SwitchPause();
            MessageBox.Show("Пробел - остановить/продолжить игру\n Клавиша влево/вправо - передвинуть фигура\n Клавиша вверх - перевернуть фигуру\n Клавиша вниз - ускорить падение");
        }


        /// <summary>
        /// Меняет уровень игры
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void выбратьУровеньToolStripMenuItem_Click(object sender, EventArgs e)
        {
            if (!isGame)
            {
                выбратьУровеньToolStripMenuItem.Enabled = true;
                ChooseLvl ChLvl = new ChooseLvl(this);
                ChLvl.ShowDialog();
                lLevel.Text = Convert.ToString(this.lvl);
            }
            else
                выбратьУровеньToolStripMenuItem.Enabled = false;
        }

       
    }
}
