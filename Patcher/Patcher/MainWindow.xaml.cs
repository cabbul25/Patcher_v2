using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Navigation;
using System.Windows.Shapes;
using System.Diagnostics;
using System.Windows.Threading;
using System.Net;
using System.IO;
using System.ComponentModel;
using System.Security.Cryptography;
using Microsoft.WindowsAPICodePack;
using Microsoft.WindowsAPICodePack.Taskbar;

namespace Patcher
{
    /// <summary>
    /// Interaction logic for MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {
        private bool IsPatched { get; set; }

        public MainWindow()
        {
            InitializeComponent();
            TextPatchinfo.Text = "Patcher by Hanashi\r\n\r\n";
            this.IsPatched = false;
        }

        private void Window_MouseLeftButtonDown(object sender, MouseButtonEventArgs e)
        {
            try
            {
                this.DragMove();
            }
            catch { }
        }

        private bool IsWin7OrHigher()
        {
            OperatingSystem OS = Environment.OSVersion;
            if (OS.Version.Major >= 6)
            {
                if (OS.Version.Minor >= 1)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }

        private void BtnCloseClick(object sender, MouseButtonEventArgs e)
        {
            this.Close();
        }

        private void BtnMinimizeClick(object sender, MouseButtonEventArgs e)
        {
            this.WindowState = WindowState.Minimized;
        }

        private void BtnSettingsClick(object sender, MouseButtonEventArgs e)
        {
            try
            {
                Process.Start(Config.ConfigurationEXE);
            }
            catch
            {
                MessageBox.Show(String.Format("Die {0} konnte nicht gefunden werden", Config.ConfigurationEXE), "Fehler", MessageBoxButton.OK, MessageBoxImage.Error);
            }
        }

        private void BtnHomepageClick(object sender, MouseButtonEventArgs e)
        {
            Process.Start(Config.HomepageURL);
        }

        private void BtnPlayClick(object sender, MouseButtonEventArgs e)
        {
            BtnPlay.IsEnabled = false;

            if (this.IsPatched)
            {
                this.StartGame();
            }
            else
            {
                BackgroundWorker bgWorker = new BackgroundWorker();
                bgWorker.DoWork += delegate
                {
                    this.GetPatchlist();
                };
                bgWorker.RunWorkerAsync();
            }
        }

        private void SetLblFile(string FileName)
        {
            LblFile.Dispatcher.Invoke(DispatcherPriority.Background, new DispatcherOperationCallback(delegate
            {
                LblFile.Content = String.Format("Datei: {0}", FileName);
                return null;
            }), null);
        }

        private void AddTextToList(string Text)
        {
            TextPatchinfo.Dispatcher.Invoke(DispatcherPriority.Background, new DispatcherOperationCallback(delegate
            {
                TextPatchinfo.Text += String.Format("{0}\r\n", Text);
                return null;
            }), null);
            ScrollText.Dispatcher.Invoke(DispatcherPriority.Background, new DispatcherOperationCallback(delegate
            {
                ScrollText.ScrollToEnd();
                return null;
            }), null);
        }

        private void EventDownloadProgres(object sender, DownloadProgressChangedEventArgs e)
        {
            LblFilePercent.Dispatcher.Invoke(System.Windows.Threading.DispatcherPriority.Background, new System.Windows.Threading.DispatcherOperationCallback(delegate
            {
                LblFilePercent.Content = String.Format("{0}%", e.ProgressPercentage);
                return null;
            }), null);
            ProgressFile.Dispatcher.Invoke(System.Windows.Threading.DispatcherPriority.Background, new System.Windows.Threading.DispatcherOperationCallback(delegate
            {
                ProgressFile.Width = 391 * e.ProgressPercentage / 100;
                return null;
            }), null);
        }

        private void SetTotalStatus(int FileNr, int TotalFiles)
        {
            int percent = 0;
            try
            {
                percent = 100 * FileNr / TotalFiles;
            }
            catch { }
            LblTotal.Dispatcher.Invoke(System.Windows.Threading.DispatcherPriority.Background, new System.Windows.Threading.DispatcherOperationCallback(delegate
            {
                LblTotal.Content = String.Format("Gesamt: {0} von {1} Dateien", FileNr, TotalFiles);
                return null;
            }), null);
            LblTotalPercent.Dispatcher.Invoke(System.Windows.Threading.DispatcherPriority.Background, new System.Windows.Threading.DispatcherOperationCallback(delegate
            {
                LblTotalPercent.Content = String.Format("{0}%", percent);
                return null;
            }), null);
            ProgressTotal.Dispatcher.Invoke(System.Windows.Threading.DispatcherPriority.Background, new System.Windows.Threading.DispatcherOperationCallback(delegate
            {
                ProgressTotal.Width = 391 * percent / 100;
                return null;
            }), null);
        }

        private void GetPatchlist()
        {
            this.SetLblFile("Patchliste");
            this.AddTextToList("Patchliste wird heruntergeladen...");

            WebClient DlPatchlist = new WebClient();
            DlPatchlist.Proxy = null;
            DlPatchlist.DownloadProgressChanged += new DownloadProgressChangedEventHandler(EventDownloadProgres);
            DlPatchlist.DownloadFileCompleted += delegate
            {
                this.AddTextToList("Patchliste wurde heruntergeladen.\r\n");
                this.ParsePatchlist();
            };
            DlPatchlist.DownloadFileAsync(new Uri(String.Format("{0}filelist/filelist.xml", Config.PatchserverURL)), "patchlist.xml");
        }

        private void ParsePatchlist()
        {
            PatchList Patchlist = PatchList.LoadFromXml("patchlist.xml");
            File.Delete("patchlist.xml");

            this.SetTotalStatus(0, Patchlist.PatchFiles.Count);

            this.DeleteFiles(Patchlist.DeleteFiles);
            this.CreateDirectories(Patchlist.PatchDirectories);
            this.PatchFile(0, Patchlist.PatchFiles);
        }

        private void DeleteFiles(List<DeleteFile> DeleteFiles)
        {
            foreach (var DeleteFile in DeleteFiles)
            {
                if (File.Exists(DeleteFile.Name))
                {
                    File.Delete(DeleteFile.Name);
                    this.AddTextToList(String.Format("{0} wurde gelöscht.\r\n", DeleteFile.Name));
                }
            }
        }

        private void CreateDirectories(List<PatchDirectory> PatchDirectories)
        {
            foreach (var PatchDirectory in PatchDirectories)
            {
                if (!Directory.Exists(PatchDirectory.Name))
                {
                    Directory.CreateDirectory(PatchDirectory.Name);
                    this.AddTextToList(String.Format("{0} wurde erstellt.\r\n", PatchDirectory.Name));
                }
            }
        }

        public string GetFileHash(string file)
        {
            if (!File.Exists(file))
                return null;
            using (var fStream = File.OpenRead(file))
                return BitConverter.ToString(new MD5CryptoServiceProvider().ComputeHash(fStream)).Replace("-", "").ToLower();
        }

        private void DownloadFile(int FileNr, List<PatchFile> PatchFiles)
        {
            this.SetLblFile(PatchFiles[FileNr].Name);
            this.AddTextToList(String.Format("Downloade {0}...", PatchFiles[FileNr].Name));

            WebClient FileDownload = new WebClient();
            FileDownload.Proxy = null;
            FileDownload.DownloadProgressChanged += new DownloadProgressChangedEventHandler(EventDownloadProgres);
            FileDownload.DownloadFileCompleted += delegate
            {
                this.AddTextToList(String.Format("{0} heruntergeladen.\r\n", PatchFiles[FileNr].Name));
                FileNr++;
                this.PatchFile(FileNr, PatchFiles);
            };
            FileDownload.DownloadFileAsync(new Uri(String.Format("{0}client/{1}", Config.PatchserverURL, PatchFiles[FileNr].Name)), PatchFiles[FileNr].Name);
        }

        private void PatchFile(int FileNr, List<PatchFile> PatchFiles)
        {
            if (this.IsWin7OrHigher())
            {
                TaskbarManager tbmanager = TaskbarManager.Instance;
                tbmanager.SetProgressState(TaskbarProgressBarState.Normal);
                tbmanager.SetProgressValue(FileNr, PatchFiles.Count);
            }
            if (FileNr >= PatchFiles.Count)
            {
                this.SetTotalStatus(FileNr, PatchFiles.Count);
                this.IsPatched = true;
                this.StartGame();
            }
            else
            {
                this.SetTotalStatus(FileNr, PatchFiles.Count);
                this.AddTextToList(String.Format("Prüfe {0}...", PatchFiles[FileNr].Name));

                if (File.Exists(PatchFiles[FileNr].Name))
                {
                    if (this.GetFileHash(PatchFiles[FileNr].Name) != PatchFiles[FileNr].Hash)
                    {
                        this.DownloadFile(FileNr, PatchFiles);
                    }
                    else
                    {
                        this.AddTextToList(String.Format("{0} ist aktuell\r\n", PatchFiles[FileNr].Name));
                        FileNr++;
                        this.PatchFile(FileNr, PatchFiles);
                    }
                }
                else
                {
                    this.DownloadFile(FileNr, PatchFiles);
                }
            }
        }

        private void StartGame()
        {

            this.AddTextToList("Das Spiel wird gestartet.\r\n");

            Process proc = new Process();
            proc.StartInfo.FileName = Config.BinaryName;
            proc.StartInfo.UseShellExecute = false;
            try
            {
                proc.Start();
            }
            catch
            {
                MessageBox.Show(String.Format("Die Datei {0} existiert nicht.", Config.BinaryName), "Fehler", MessageBoxButton.OK, MessageBoxImage.Error);
            }

            if (this.IsWin7OrHigher())
            {
                TaskbarManager tbmanager = TaskbarManager.Instance;
                tbmanager.SetProgressState(TaskbarProgressBarState.NoProgress);
            }

            BtnPlay.Dispatcher.Invoke(System.Windows.Threading.DispatcherPriority.Background, new System.Windows.Threading.DispatcherOperationCallback(delegate
            {
                BtnPlay.IsEnabled = true;
                return null;
            }), null);
        }

        private void Window_Loaded(object sender, RoutedEventArgs e)
        {
            if (File.Exists("Updater.exe"))
            {
                File.Delete("Updater.exe");
            }
            WebClient wbClient = new WebClient();
            wbClient.Proxy = null;
            wbClient.DownloadStringCompleted += new DownloadStringCompletedEventHandler(VersionDownload);
            wbClient.DownloadStringAsync(new Uri(String.Format("{0}admin/index.php?ajax&version", Config.PatchserverURL)));
        }

        public void VersionDownload(Object sender, DownloadStringCompletedEventArgs e)
        {
            if (!e.Cancelled && e.Error == null)
            {
                string result = (string)e.Result;
                string[] lines = result.Split('\n');

                if (lines[0] != System.Reflection.Assembly.GetExecutingAssembly().GetName().Version.ToString())
                {
                    BtnPlay.IsEnabled = false;
                    MessageBox.Show("Es steht eine neue Version des Patchers zur Verfügung, diese wird nun automatisch heruntergeladen. Bitte gedulde dich einen Augenblick.", "Info", MessageBoxButton.OK, MessageBoxImage.Information);
                    LblFile.Content = "Datei: Updater.exe";

                    WebClient FileDownload = new WebClient();
                    FileDownload.Proxy = null;
                    FileDownload.DownloadProgressChanged += new DownloadProgressChangedEventHandler(EventDownloadProgres);
                    FileDownload.DownloadFileCompleted += delegate
                    {
                        try
                        {
                            Process.Start("Updater.exe");
                            this.Close();
                        }
                        catch
                        {
                            MessageBox.Show("Die Updater.exe wurde nicht gefunden.", "Fehler", MessageBoxButton.OK, MessageBoxImage.Error);
                        }
                    };
                    FileDownload.DownloadFileAsync(new Uri(String.Format("{0}update/Updater.exe", Config.PatchserverURL)), "Updater.exe");
                }
            }
        }
    }
}
