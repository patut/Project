namespace TetrisGame
{
    partial class Tetris
    {
        /// <summary>
        /// Требуется переменная конструктора.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Освободить все используемые ресурсы.
        /// </summary>
        /// <param name="disposing">истинно, если управляемый ресурс должен быть удален; иначе ложно.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Код, автоматически созданный конструктором форм Windows

        /// <summary>
        /// Обязательный метод для поддержки конструктора - не изменяйте
        /// содержимое данного метода при помощи редактора кода.
        /// </summary>
        private void InitializeComponent()
        {
            this.components = new System.ComponentModel.Container();
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(Tetris));
            this.menuStrip1 = new System.Windows.Forms.MenuStrip();
            this.играToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.новаяИграToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.паузаToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripMenuItem1 = new System.Windows.Forms.ToolStripSeparator();
            this.выходToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.выбратьУровеньToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.справкаToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.layout0 = new System.Windows.Forms.TableLayoutPanel();
            this.main = new System.Windows.Forms.PictureBox();
            this.layout1 = new System.Windows.Forms.TableLayoutPanel();
            this.next = new System.Windows.Forms.PictureBox();
            this.layout11 = new System.Windows.Forms.TableLayoutPanel();
            this.label1 = new System.Windows.Forms.Label();
            this.label2 = new System.Windows.Forms.Label();
            this.label3 = new System.Windows.Forms.Label();
            this.lLevel = new System.Windows.Forms.Label();
            this.lLines = new System.Windows.Forms.Label();
            this.lScore = new System.Windows.Forms.Label();
            this.time = new System.Windows.Forms.Timer(this.components);
            this.menuStrip1.SuspendLayout();
            this.layout0.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.main)).BeginInit();
            this.layout1.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.next)).BeginInit();
            this.layout11.SuspendLayout();
            this.SuspendLayout();
            // 
            // menuStrip1
            // 
            this.menuStrip1.Items.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.играToolStripMenuItem,
            this.выбратьУровеньToolStripMenuItem,
            this.справкаToolStripMenuItem});
            this.menuStrip1.Location = new System.Drawing.Point(0, 0);
            this.menuStrip1.Name = "menuStrip1";
            this.menuStrip1.Size = new System.Drawing.Size(578, 24);
            this.menuStrip1.TabIndex = 0;
            this.menuStrip1.Text = "menuStrip1";
            // 
            // играToolStripMenuItem
            // 
            this.играToolStripMenuItem.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.новаяИграToolStripMenuItem,
            this.паузаToolStripMenuItem,
            this.toolStripMenuItem1,
            this.выходToolStripMenuItem});
            this.играToolStripMenuItem.Name = "играToolStripMenuItem";
            this.играToolStripMenuItem.Size = new System.Drawing.Size(46, 20);
            this.играToolStripMenuItem.Text = "Игра";
          
            // 
            // новаяИграToolStripMenuItem
            // 
            this.новаяИграToolStripMenuItem.Name = "новаяИграToolStripMenuItem";
            this.новаяИграToolStripMenuItem.Size = new System.Drawing.Size(138, 22);
            this.новаяИграToolStripMenuItem.Text = "Новая Игра";
            this.новаяИграToolStripMenuItem.Click += new System.EventHandler(this.новаяИграToolStripMenuItem_Click);
            // 
            // паузаToolStripMenuItem
            // 
            this.паузаToolStripMenuItem.Name = "паузаToolStripMenuItem";
            this.паузаToolStripMenuItem.Size = new System.Drawing.Size(138, 22);
            this.паузаToolStripMenuItem.Text = "Пауза";
            this.паузаToolStripMenuItem.ToolTipText = "Горячая клавиша - пробел";
            this.паузаToolStripMenuItem.Click += new System.EventHandler(this.паузаToolStripMenuItem_Click);
            // 
            // toolStripMenuItem1
            // 
            this.toolStripMenuItem1.Name = "toolStripMenuItem1";
            this.toolStripMenuItem1.Size = new System.Drawing.Size(135, 6);
            // 
            // выходToolStripMenuItem
            // 
            this.выходToolStripMenuItem.Name = "выходToolStripMenuItem";
            this.выходToolStripMenuItem.Size = new System.Drawing.Size(138, 22);
            this.выходToolStripMenuItem.Text = "Выход";
            this.выходToolStripMenuItem.Click += new System.EventHandler(this.выходToolStripMenuItem_Click);
            // 
            // выбратьУровеньToolStripMenuItem
            // 
            this.выбратьУровеньToolStripMenuItem.Name = "выбратьУровеньToolStripMenuItem";
            this.выбратьУровеньToolStripMenuItem.Size = new System.Drawing.Size(114, 20);
            this.выбратьУровеньToolStripMenuItem.Text = "Выбрать уровень";
            this.выбратьУровеньToolStripMenuItem.Click += new System.EventHandler(this.выбратьУровеньToolStripMenuItem_Click);
            // 
            // справкаToolStripMenuItem
            // 
            this.справкаToolStripMenuItem.Name = "справкаToolStripMenuItem";
            this.справкаToolStripMenuItem.Size = new System.Drawing.Size(65, 20);
            this.справкаToolStripMenuItem.Text = "Справка";
            this.справкаToolStripMenuItem.Click += new System.EventHandler(this.справкаToolStripMenuItem_Click);
            // 
            // layout0
            // 
            this.layout0.CellBorderStyle = System.Windows.Forms.TableLayoutPanelCellBorderStyle.Inset;
            this.layout0.ColumnCount = 2;
            this.layout0.ColumnStyles.Add(new System.Windows.Forms.ColumnStyle(System.Windows.Forms.SizeType.Percent, 68.51211F));
            this.layout0.ColumnStyles.Add(new System.Windows.Forms.ColumnStyle(System.Windows.Forms.SizeType.Percent, 31.48789F));
            this.layout0.Controls.Add(this.main, 0, 0);
            this.layout0.Controls.Add(this.layout1, 1, 0);
            this.layout0.Dock = System.Windows.Forms.DockStyle.Fill;
            this.layout0.Location = new System.Drawing.Point(0, 24);
            this.layout0.Name = "layout0";
            this.layout0.RowCount = 1;
            this.layout0.RowStyles.Add(new System.Windows.Forms.RowStyle(System.Windows.Forms.SizeType.Percent, 68.33334F));
            this.layout0.RowStyles.Add(new System.Windows.Forms.RowStyle(System.Windows.Forms.SizeType.Absolute, 20F));
            this.layout0.Size = new System.Drawing.Size(578, 517);
            this.layout0.TabIndex = 1;
            // 
            // main
            // 
            this.main.Dock = System.Windows.Forms.DockStyle.Fill;
            this.main.Location = new System.Drawing.Point(5, 5);
            this.main.Name = "main";
            this.main.Size = new System.Drawing.Size(385, 507);
            this.main.TabIndex = 1;
            this.main.TabStop = false;
            // 
            // layout1
            // 
            this.layout1.CellBorderStyle = System.Windows.Forms.TableLayoutPanelCellBorderStyle.Single;
            this.layout1.ColumnCount = 1;
            this.layout1.ColumnStyles.Add(new System.Windows.Forms.ColumnStyle(System.Windows.Forms.SizeType.Absolute, 20F));
            this.layout1.Controls.Add(this.next, 0, 0);
            this.layout1.Controls.Add(this.layout11, 0, 1);
            this.layout1.Location = new System.Drawing.Point(398, 5);
            this.layout1.Name = "layout1";
            this.layout1.RowCount = 2;
            this.layout1.RowStyles.Add(new System.Windows.Forms.RowStyle(System.Windows.Forms.SizeType.Percent, 26.61448F));
            this.layout1.RowStyles.Add(new System.Windows.Forms.RowStyle(System.Windows.Forms.SizeType.Percent, 73.38552F));
            this.layout1.Size = new System.Drawing.Size(175, 507);
            this.layout1.TabIndex = 2;
            
            // 
            // next
            // 
            this.next.Dock = System.Windows.Forms.DockStyle.Fill;
            this.next.Location = new System.Drawing.Point(4, 4);
            this.next.Name = "next";
            this.next.Size = new System.Drawing.Size(167, 128);
            this.next.TabIndex = 1;
            this.next.TabStop = false;
            // 
            // layout11
            // 
            this.layout11.BackgroundImageLayout = System.Windows.Forms.ImageLayout.None;
            this.layout11.CellBorderStyle = System.Windows.Forms.TableLayoutPanelCellBorderStyle.InsetDouble;
            this.layout11.ColumnCount = 2;
            this.layout11.ColumnStyles.Add(new System.Windows.Forms.ColumnStyle());
            this.layout11.ColumnStyles.Add(new System.Windows.Forms.ColumnStyle());
            this.layout11.Controls.Add(this.label1, 0, 0);
            this.layout11.Controls.Add(this.label2, 0, 1);
            this.layout11.Controls.Add(this.label3, 0, 2);
            this.layout11.Controls.Add(this.lLevel, 1, 0);
            this.layout11.Controls.Add(this.lLines, 1, 1);
            this.layout11.Controls.Add(this.lScore, 1, 2);
            this.layout11.Font = new System.Drawing.Font("Tahoma", 12F);
            this.layout11.Location = new System.Drawing.Point(4, 139);
            this.layout11.Name = "layout11";
            this.layout11.RowCount = 3;
            this.layout11.RowStyles.Add(new System.Windows.Forms.RowStyle());
            this.layout11.RowStyles.Add(new System.Windows.Forms.RowStyle());
            this.layout11.RowStyles.Add(new System.Windows.Forms.RowStyle());
            this.layout11.Size = new System.Drawing.Size(167, 72);
            this.layout11.TabIndex = 0;
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point(6, 3);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(69, 19);
            this.label1.TabIndex = 0;
            this.label1.Text = "Уровень";
            // 
            // label2
            // 
            this.label2.AutoSize = true;
            this.label2.Location = new System.Drawing.Point(6, 25);
            this.label2.Name = "label2";
            this.label2.Size = new System.Drawing.Size(56, 19);
            this.label2.TabIndex = 1;
            this.label2.Text = "Линии";
            // 
            // label3
            // 
            this.label3.AutoSize = true;
            this.label3.Location = new System.Drawing.Point(6, 47);
            this.label3.Name = "label3";
            this.label3.Size = new System.Drawing.Size(47, 19);
            this.label3.TabIndex = 2;
            this.label3.Text = "Очки";
            // 
            // lLevel
            // 
            this.lLevel.AutoSize = true;
            this.lLevel.Location = new System.Drawing.Point(84, 3);
            this.lLevel.Name = "lLevel";
            this.lLevel.Size = new System.Drawing.Size(18, 19);
            this.lLevel.TabIndex = 3;
            this.lLevel.Text = "1";
            // 
            // lLines
            // 
            this.lLines.AutoSize = true;
            this.lLines.Location = new System.Drawing.Point(84, 25);
            this.lLines.Name = "lLines";
            this.lLines.Size = new System.Drawing.Size(18, 19);
            this.lLines.TabIndex = 4;
            this.lLines.Text = "0";
            // 
            // lScore
            // 
            this.lScore.AutoSize = true;
            this.lScore.Location = new System.Drawing.Point(84, 47);
            this.lScore.Name = "lScore";
            this.lScore.Size = new System.Drawing.Size(18, 19);
            this.lScore.TabIndex = 5;
            this.lScore.Text = "0";
            // 
            // time
            // 
            this.time.Interval = 1000;
            this.time.Tick += new System.EventHandler(this.time_Tick);
            // 
            // Tetris
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(578, 541);
            this.Controls.Add(this.layout0);
            this.Controls.Add(this.menuStrip1);
            this.Icon = ((System.Drawing.Icon)(resources.GetObject("$this.Icon")));
            this.KeyPreview = true;
            this.MainMenuStrip = this.menuStrip1;
            this.Name = "Tetris";
            this.Text = "Тетрис";
            this.PreviewKeyDown += new System.Windows.Forms.PreviewKeyDownEventHandler(this.Tetris_PreviewKeyDown);
            this.Resize += new System.EventHandler(this.Tetris_Resize);
            this.menuStrip1.ResumeLayout(false);
            this.menuStrip1.PerformLayout();
            this.layout0.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.main)).EndInit();
            this.layout1.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.next)).EndInit();
            this.layout11.ResumeLayout(false);
            this.layout11.PerformLayout();
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.MenuStrip menuStrip1;
        private System.Windows.Forms.ToolStripMenuItem играToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem новаяИграToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem паузаToolStripMenuItem;
        private System.Windows.Forms.ToolStripSeparator toolStripMenuItem1;
        private System.Windows.Forms.ToolStripMenuItem выходToolStripMenuItem;
        private System.Windows.Forms.TableLayoutPanel layout0;
        private System.Windows.Forms.PictureBox main;
        private System.Windows.Forms.Timer time;
        private System.Windows.Forms.TableLayoutPanel layout1;
        private System.Windows.Forms.TableLayoutPanel layout11;
        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.Label label2;
        private System.Windows.Forms.Label label3;
        private System.Windows.Forms.Label lLevel;
        private System.Windows.Forms.Label lLines;
        private System.Windows.Forms.Label lScore;
        private System.Windows.Forms.PictureBox next;
        private System.Windows.Forms.ToolStripMenuItem справкаToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem выбратьУровеньToolStripMenuItem;
    }
}

