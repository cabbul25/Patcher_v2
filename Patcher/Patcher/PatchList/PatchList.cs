using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.IO;
using System.Xml.Serialization;
using System.Xml;

namespace Patcher
{
    public class PatchList
    {
        public List<DeleteFile> DeleteFiles { get; set; }
        public List<PatchDirectory> PatchDirectories { get; set; }
        public List<PatchFile> PatchFiles { get; set; }

        public PatchList()
        {
            this.DeleteFiles = new List<DeleteFile>();
            this.PatchDirectories = new List<PatchDirectory>();
            this.PatchFiles = new List<PatchFile>();
        }

        public static PatchList LoadFromXml(string Filename)
        {
            if (!File.Exists(Filename))
                throw new FileNotFoundException(Filename);
            var Serializer = new XmlSerializer(typeof(PatchList));
            var XmlReader = new XmlTextReader(Filename);
            PatchList ReturnObject = new PatchList();
            try
            {
                ReturnObject = (PatchList)Serializer.Deserialize(XmlReader);
            }
            catch
            {
            }
            XmlReader.Close();
            return ReturnObject;
        }
    }
}
