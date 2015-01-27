using System;
using System.Text;
using System.Collections.Generic;
using System.Linq;
using Microsoft.VisualStudio.TestTools.UnitTesting;
using System.Drawing;

namespace Test.Tests
{
    [TestClass]
    public class UnitTest1
    {
        [TestMethod]
        public void TestTryFlash()
        {
            byte[][] matrix = new byte[20][];
            for (int i = 0; i < matrix.Length; i++)
            {
                matrix[i] = new byte[10];
            }
            Point[] example = new Point[4];
            example[0] = new Point(1, -1);
            example[1] = new Point(1, 0);
            example[2] = new Point(2, -1);
            example[3] = new Point(2, 0);

            Assert.IsFalse(TetrisGame.Methods.TryFlashMatrix(example,matrix,example));
        }

        [TestMethod]
        public void TestFlash()
        {
            byte[][] matrix = new byte[20][];
            for (int i = 0; i < matrix.Length; i++)
            {
                matrix[i] = new byte[10];
            }
            matrix[0][0] = 2;
            TetrisGame.Methods.FlashMatrix(matrix);
            Assert.AreEqual(1, matrix[0][0]);
        }
        
        [TestMethod]
        public void TestStep()
        {
           byte[][] matrix = new byte[20][];
           for (int i = 0; i<matrix.Length; i++)
           {
               matrix[i] = new byte[10];
           }
           matrix[0][0] = 2;
           matrix[0][1] = 2;
           matrix[1][0] = 2;
           matrix[1][1] = 2;
           Point[] expected = new Point[4];
           expected[0] = new Point(1, 0);
           expected[1] = new Point(1, 1);
           expected[2] = new Point(2, 0);
           expected[3] = new Point(2, 1);


           Point[] points = TetrisGame.Methods.Step(matrix);
           for (int i = 0; i < points.Length; i++)
           {
               Assert.AreEqual(expected[i].X, points[i].X);
               Assert.AreEqual(expected[i].Y, points[i].Y);
           }
        }

        [TestMethod]
        public void TestRight()
        {
            byte[][] matrix = new byte[20][];
            for (int i = 0; i < matrix.Length; i++)
            {
                matrix[i] = new byte[10];
            }
            matrix[0][0] = 2;
            matrix[0][1] = 2;
            matrix[1][0] = 2;
            matrix[1][1] = 2;
            Point[] expected = new Point[4];
            expected[0] = new Point(0, 1);
            expected[1] = new Point(0, 2);
            expected[2] = new Point(1, 1);
            expected[3] = new Point(1, 2);


            Point[] points = TetrisGame.Methods.ShiftRight(matrix);
            for (int i = 0; i < points.Length; i++)
            {
                Assert.AreEqual(expected[i].X, points[i].X);
                Assert.AreEqual(expected[i].Y, points[i].Y);
            }
        }

        [TestMethod]
        public void TestLight()
        {
            byte[][] matrix = new byte[20][];
            for (int i = 0; i < matrix.Length; i++)
            {
                matrix[i] = new byte[10];
            }
            matrix[1][1] = 2;
            matrix[1][2] = 2;
            matrix[2][1] = 2;
            matrix[2][2] = 2;
            Point[] expected = new Point[4];
            expected[0] = new Point(1, 0);
            expected[1] = new Point(1, 1);
            expected[2] = new Point(2, 0);
            expected[3] = new Point(2, 1);


            Point[] points = TetrisGame.Methods.ShiftLeft(matrix);
            for (int i = 0; i < points.Length; i++)
            {
                Assert.AreEqual(expected[i].X, points[i].X);
                Assert.AreEqual(expected[i].Y, points[i].Y);
            }
        }
    }
}
