using System;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;

namespace TetrisGame
{
    
    public partial class ChooseLvl : Form
    {
        Tetris Tetrisref;
        public ChooseLvl(Tetris link)
        {
            InitializeComponent();
            Tetrisref = link;
        }

        private void Ok_Click(object sender, EventArgs e)
        {
            Tetrisref.lvl=Convert.ToByte(comboBox1.SelectedItem);
            this.Close();
        }
    }
}
